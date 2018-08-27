<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 20/8/18
 * Time: 3:41 PM
 */

namespace App\models\utils;


use App\models\role\status\IColor;

class LifetimeUtil
{
    const Platinum  = 500000;
    const Gold      = 325000;
    const Silver    = 200000;
    const Bronze    = 100000;

    const MaxLevelText  = 'Max';
    const PlatinumText  = 'Platinum';
    const GoldText      = 'Gold';
    const SilverText    = 'Silver';
    const BronzeText    = 'Bronze';

    public $color;
    public $next_level;
    public $lifetime_to_reach_credits;

    /**
     * Constructor, by default is the lowest one
     * LifetimeUtil constructor.
     * @param int $lifetime
     */
    public function __construct($lifetime = 0)
    {
        $this->_init(
            IColor::BasicLifetime,
            self::BronzeText,
            self::Bronze - $lifetime);
    }

    public function getGagaData(){
        return [
            [self::Bronze, IColor::Bronze, self::BronzeText],
            [self::Silver, IColor::Silver, self::SilverText],
            [self::Gold, IColor::Gold, self::GoldText],
            [self::Platinum, IColor::Platinum, self::PlatinumText],
        ];
    }

    /**
     * Get Text
     * @param $key
     * @return string
     */
    public function getText($key){
        $result = self::BronzeText;
        switch ($key){
            case self::PlatinumText:
                $result = self::PlatinumText;
                break;
            case self::GoldText:
                $result = self::GoldText;
                break;
            case self::SilverText:
                $result = self::SilverText;
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * Get Text
     * @param $key
     * @return int
     */
    public function getLevelValue($key){
        $result = self::Bronze;
        switch ($key){
            case self::PlatinumText:
                $result = self::Platinum;
                break;
            case self::GoldText:
                $result = self::Gold;
                break;
            case self::SilverText:
                $result = self::Silver;
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * Get Instance
     * @param $lifetimeRevenue
     * @return LifetimeUtil
     */
    public static function GetInstance($lifetimeRevenue){
        $lifetimeUtil = new LifetimeUtil($lifetimeRevenue);
        switch ($lifetimeRevenue){
            case $lifetimeRevenue >= self::Platinum:
                $lifetimeUtil->_init(IColor::Platinum,self::MaxLevelText, 0);
                break;
            case $lifetimeRevenue >= self::Gold && $lifetimeRevenue < self::Platinum:
                $lifetimeUtil->_init(
                    IColor::Gold,
                    self::PlatinumText,
                    self::Platinum - $lifetimeRevenue);
                break;
            case $lifetimeRevenue >= self::Silver && $lifetimeRevenue < self::Gold:
                $lifetimeUtil->_init(
                    IColor::Silver,
                    self::GoldText,
                    self::Gold - $lifetimeRevenue);
                break;

            case $lifetimeRevenue >= self::Bronze && $lifetimeRevenue < self::Silver:
                $lifetimeUtil->_init(
                    IColor::Bronze,
                    self::SilverText,
                    self::Silver - $lifetimeRevenue);
                break;
            default:
                break;
        }

        return $lifetimeUtil;
    }

    /**
     * Init the lifetime util
     * @param $color
     * @param $next_level
     * @param $lifetime_to_reach_credits
     */
    private function _init($color,$next_level, $lifetime_to_reach_credits ){
        $this->color = $color;
        $this->next_level = $next_level;
        $this->lifetime_to_reach_credits = $lifetime_to_reach_credits;
    }
}