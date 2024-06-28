<?php

namespace App\Services\StatusServices;
use App\Models\Reward;

class GageStatus {

    const PREMIER_CLASS_STRING       = 'T-P';
    const AMBASSADOR_CLASS_STRING     = 'T-A';
    const DIPLOMAT_CLASS_STRING       = 'T-D';
    const CONSUL_CLASS_STRING        = 'T-C';
    const DEFAULT_CLASS_STRING        = '';

    protected $consul = null;
    protected $diplomat = null;
    protected $ambassador = null;
    protected $premier = null;

    protected $min = 0;
    protected $max = 50000;

    protected $completed = 0;

    protected $color = null;
    protected $colorText = null;
    protected $toReach = 0;
    protected $indicators = [];

    public function __construct(Reward $rewards, $completed) {

        $this->consul = $rewards->commendation;
        $this->diplomat = $rewards->bronze;
        $this->ambassador = $rewards->silver;
        $this->premier = $rewards->gold;
        $this->max = $rewards->max;
        $this->completed = intval($completed);
        $this->setGageIndicators();
        $this->initColor();
    }

    /**
     * Compare year to date value is in which range
     * @param $smaller
     * @param null $bigger
     * @return bool
     */
    protected function _inBetween($smaller, $bigger = null){
        if(is_null($bigger)){
            return $this->completed >= $smaller;
        }else{
            return $this->completed >= $smaller && $this->completed < $bigger;
        }
    }

    public function __get($name) {
        $value = null;
        switch($name) {
            case 'indicators':
                $value = $this->indicators;
                break;
            case 'min':
                $value = $this->min;
                break;
            case 'max':
                $value = $this->max;
                break;
            case 'completed':
                $value = $this->completed;
                break;
            case 'color':
                $value = $this->color;
                break;
            case 'colorText':
                $value = $this->colorText;
                break;
            case 'toReach':

                if (!$this->toReach) {
                    $value = '';
                } else {
                    $value = number_format($this->toReach,0);
                }
                break;
            default:
                break;
        }
        return $value;
    }

    public function __set($name, $value) {
        switch($name) {
            case 'indicators':
                $this->indicators = $value;
                break;
            case 'min':
                $this->min = $value;
                break;
            case 'max':
                $this->max = $value;
                break;
            default:
                break;
        }
    }
}
