<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/7/18
 * Time: 9:22 AM
 */

namespace App\models\role\status;

class GageStatus
{
    const STATUS_LEVEL_4       = 'Gold';
    const STATUS_LEVEL_3    = 'Silver';
    const STATUS_LEVEL_2      = 'Bronze';
    const STATUS_LEVEL_1        = 'Commendation';
    const STATUS_LEVEL_DEFAULT       = 'Default';

    const STATUS_LEVEL_4_COLOR       = '#FFD700'; //gold
    const STATUS_LEVEL_3_COLOR    = '#C0C0C0'; //silver
    const STATUS_LEVEL_2_COLOR      = '#8B4513'; //SaddleBrown
    const STATUS_LEVEL_1_COLOR        = '#525357';
    const STATUS_LEVEL_DEFAULT_COLOR       = '#000000';

    const PREMIER_CLASS_STRING       = 'T-P';
    const AMBASSADOR_CLASS_STRING     = 'T-A';
    const DIPLOMAT_CLASS_STRING       = 'T-D';
    const CONSUL_CLASS_STRING        = 'T-C';
    const DEFAULT_CLASS_STRING        = '';

    private $consul = null;
    private $diplomat = null;
    private $ambassador = null;
    private $premier = null;

    private $options = [];

    private $min = 0;
    private $max = 50000;

    private $yearToDate = 0;

    private $color = null;
    private $colorText = null;
    private $toReach = 0;
    private $indicators = [];

    public function __construct($consul, $diplomat, $ambassador, $premier,$yearToDate, $max, $min = 0)
    {
        $this->consul = $consul;
        $this->diplomat = $diplomat;
        $this->ambassador = $ambassador;
        $this->premier = $premier;
        $this->max = $max;
        $this->min = $min;
        $this->yearToDate = $yearToDate;
        $this->setGageIndicators([
            [
                ($this->consul/$this->max) * 100, self::STATUS_LEVEL_1_COLOR, self::STATUS_LEVEL_1
            ],
            [
                ($this->diplomat/$this->max) * 100, self::STATUS_LEVEL_2_COLOR, self::STATUS_LEVEL_2
            ],
            [
                ($this->ambassador/$this->max) * 100, self::STATUS_LEVEL_3_COLOR, self::STATUS_LEVEL_3
            ],
            [
                ($this->premier/$this->max) * 100, self::STATUS_LEVEL_4_COLOR, self::STATUS_LEVEL_4
            ],
        ]);
        $this->initColor();
    }

    /**
     * Init the color's attributes
     */
    public function initColor(){
        if($this->_inBetween($this->premier)){
            $this->color = self::STATUS_LEVEL_4_COLOR;
        }elseif($this->_inBetween($this->ambassador, $this->premier)){
            $this->color = self::STATUS_LEVEL_3_COLOR;
            $this->colorText = strtolower(env('PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_4).' level';
            $this->toReach = $this->premier - $this->yearToDate;
        }elseif($this->_inBetween($this->diplomat, $this->ambassador)){
            $this->color = self::STATUS_LEVEL_2_COLOR;
            $this->colorText = strtolower(env('PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_3).' level';
            $this->toReach = $this->ambassador - $this->yearToDate;
        }elseif($this->_inBetween($this->consul, $this->diplomat)){
            $this->color = self::STATUS_LEVEL_1_COLOR;
            $this->colorText = strtolower(env('PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_2).' level';
            $this->toReach = $this->diplomat - $this->yearToDate;
        }else{
            $this->color = self::STATUS_LEVEL_DEFAULT_COLOR;
            $this->colorText = strtolower(env('PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_1).' level';
            $this->toReach = $this->consul - $this->yearToDate;
        }
    }

    /**
     * Return a string for different credits value
     * @return string
     */
    public function getClassString(){
        $classString = self::DEFAULT_CLASS_STRING;

        if($this->_inBetween($this->premier)){
            $classString = self::PREMIER_CLASS_STRING;
        }elseif ($this->_inBetween($this->ambassador, $this->premier)){
            $classString = self::DIPLOMAT_CLASS_STRING;
        }elseif ( $this->_inBetween($this->diplomat, $this->ambassador) ){
            $classString = self::AMBASSADOR_CLASS_STRING;
        }elseif ( $this->_inBetween($this->consul, $this->diplomat) ){
            $classString = self::CONSUL_CLASS_STRING;
        }
        return $classString;
    }

    /**
     * Compare year to date value is in which range
     * @param $smaller
     * @param null $bigger
     * @return bool
     */
    private function _inBetween($smaller, $bigger = null){
        if(is_null($bigger)){
            return $this->yearToDate >= $smaller;
        }else{
            return $this->yearToDate >= $smaller && $this->yearToDate < $bigger;
        }
    }

    /**
     * @deprecated No use any more
     * @param string $id
     * @return string
     */
    public function getGageIndicatorJsString($id='g1'){
        $result = '';
        foreach ($this->getGageIndicators() as $gageIndicator) {
            $result .= 'generateGageIndicator("'.$id.'",'.$gageIndicator[0].',"'.$gageIndicator[1].'","'.$gageIndicator[2].'");';
        }
        return $result;
    }

    public function getGageIndicators(){
        return $this->indicators;
    }

    public function setGageIndicators($indicators){
        $this->indicators = $indicators;
    }

    /**
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return int
     */
    public function getYearToDate()
    {
        return $this->yearToDate;
    }

    /**
     * @return array
     */
    public function getIndicators()
    {
        return $this->indicators;
    }

    /**
     * @return null
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return null
     */
    public function getColorText()
    {
        return $this->colorText;
    }

    /**
     * @return int
     */
    public function getToReach()
    {
        if (!$this->toReach) return '';
        return number_format($this->toReach,0);
    }

    /**
     * @return null
     */
    public function getConsul()
    {
        return $this->consul;
    }

    /**
     * @param null $consul
     */
    public function setConsul($consul)
    {
        $this->consul = $consul;
    }

    /**
     * @return null
     */
    public function getDiplomat()
    {
        return $this->diplomat;
    }

    /**
     * @param null $diplomat
     */
    public function setDiplomat($diplomat)
    {
        $this->diplomat = $diplomat;
    }

    /**
     * @return null
     */
    public function getAmbassador()
    {
        return $this->ambassador;
    }

    /**
     * @param null $ambassador
     */
    public function setAmbassador($ambassador)
    {
        $this->ambassador = $ambassador;
    }

    /**
     * @return null
     */
    public function getPremier()
    {
        return $this->premier;
    }

    /**
     * @param null $premier
     */
    public function setPremier($premier)
    {
        $this->premier = $premier;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }


}