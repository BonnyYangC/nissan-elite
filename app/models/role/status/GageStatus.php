<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/7/18
 * Time: 9:22 AM
 */

namespace App\models\role\status;


use App\models\role\IRole;

class GageStatus
{
    const PREMIER_COLOR       = '#B47C37';
    const AMBASSADOR_COLOR    = '#546E22';
    const DIPLOMAT_COLOR      = '#BC2628';
    const CONSUL_COLOR        = '#525357';
    const DEFAULT_COLOR       = '#000000';

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
                ($this->consul/$this->max) * 100, '#525357', 'Consul'
            ],
            [
                ($this->diplomat/$this->max) * 100, '#BC2628', 'Diplomat'
            ],
            [
                ($this->ambassador/$this->max) * 100, '#546E22', 'Ambassador'
            ],
            [
                ($this->premier/$this->max) * 100, '#B47C37', 'Premier'
            ],
        ]);
        $this->initColor();
    }

    /**
     * Init the color's attributes
     */
    public function initColor(){
        if($this->yearToDate >= $this->premier){
            $this->color = self::PREMIER_COLOR;
        }elseif($this->yearToDate >= $this->ambassador){
            $this->color = self::AMBASSADOR_COLOR;
            $this->colorText = 'credits to reach '.ucfirst(IRole::PREMIER_STR).' level';
            $this->toReach = $this->premier - $this->yearToDate;
        }elseif($this->yearToDate >= $this->diplomat){
            $this->color = self::DIPLOMAT_COLOR;
            $this->colorText = 'credits to reach '.ucfirst(IRole::AMBASSADOR_STR).' level';
            $this->toReach = $this->ambassador - $this->yearToDate;
        }elseif($this->yearToDate >= $this->consul){
            $this->color = self::CONSUL_COLOR;
            $this->colorText = 'credits to reach '.ucfirst(IRole::DIPLOMAT_STR).' level';
            $this->toReach = $this->diplomat - $this->yearToDate;
        }else{
            $this->color = self::DEFAULT_COLOR;
            $this->colorText = 'credits to reach '.ucfirst(IRole::CONSUL_STR).' level';
            $this->toReach = $this->consul - $this->yearToDate;
        }
    }

    /**
     * 获取整个的字符串
     * @param string $id
     * @return string
     */
    public function getGageIndicatorJsString($id='g1'){
        $result = '';
        foreach ($this->getGageIndicators() as $gageIndicator) {
            $result .= 'generateGageIndicator("'.$id.'",'.$gageIndicator[0].',"'.$gageIndicator[1].'","'.$gageIndicator[2].'")';
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