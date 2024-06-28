<?php

namespace App\Services\StatusServices;
use App\Helper\Role;
use App\Models\Reward;


class Techician extends GageStatus{

    const LEGEND_LEVEL_4       = 'Gold                    Master Techician'; // don't remove space
    const LEGEND_LEVEL_3       = 'Silver                  Master Techician';
    const LEGEND_LEVEL_2       = 'Bronze                Advanced Techician';
    const LEGEND_LEVEL_1       = 'Commendation  Master/Advanced Techician';

    const STATUS_LEVEL_4       = 'Gold';
    const STATUS_LEVEL_3    = 'Silver';
    const STATUS_LEVEL_2      = 'Bronze';
    const STATUS_LEVEL_1        = 'Commendation';

    const STATUS_LEVEL_4_COLOR       = '#FFD700'; //gold
    const STATUS_LEVEL_3_COLOR    = '#C0C0C0'; //silver
    const STATUS_LEVEL_2_COLOR      = '#8B4513'; //SaddleBrown
    const STATUS_LEVEL_1_COLOR        = '#525357';
    const STATUS_LEVEL_DEFAULT_COLOR       = '#000000';


    private $role;
    public function __construct(Reward $rewards, $completed, string $role) {
        parent::__construct($rewards, $completed);
        $this->role = $role;
    }

    public function initColor(){
        // if($this->_inBetween($this->premier)){
        //     // $this->color = self::STATUS_LEVEL_4_COLOR;
        // }elseif($this->_inBetween($this->ambassador, $this->premier)){
        //     // $this->color = self::STATUS_LEVEL_3_COLOR;
        //     $this->colorText = strtolower(config('elite.PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_4).' level';
        //     $this->toReach = $this->premier - $this->completed;
        // }elseif($this->_inBetween($this->diplomat, $this->ambassador)){
        //     // $this->color = self::STATUS_LEVEL_2_COLOR;
        //     $this->colorText = strtolower(config('elite.PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_3).' level';
        //     $this->toReach = $this->ambassador - $this->completed;
        // }elseif($this->_inBetween($this->consul, $this->diplomat)){
        //     // $this->color = self::STATUS_LEVEL_1_COLOR;
        //     $this->colorText = strtolower(config('elite.PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_2).' level';
        //     $this->toReach = $this->diplomat - $this->completed;
        // }else{
        //     // $this->color = self::STATUS_LEVEL_DEFAULT_COLOR;
        //     $this->colorText = strtolower(config('elite.PROGRAM_AWARD_UNIT')) .' to reach '.ucfirst(self::STATUS_LEVEL_1).' level';
        //     $this->toReach = $this->consul - $this->completed;
        // }
    }

    public function setGageIndicators(){
        $this->indicators = [
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
        ];
    }

    /**
     * Return a string for different credits value
     * @return string
     */
    public function getClassString(){

        $classString = GageStatus::DEFAULT_CLASS_STRING;
        switch($this->role) {
            case Role::ADVANCED_TECHNICIAN:
                if(intval($this->completed) <= 20){
                    $classString = GageStatus::AMBASSADOR_CLASS_STRING;
                }else{
                    $classString = GageStatus::CONSUL_CLASS_STRING;
                }
                break;
            case Role::MASTER_TECHNICIAN:
                if(intval($this->completed) <= 10){
                    $classString = GageStatus::PREMIER_CLASS_STRING;
                }else if(intval($this->completed) <= 30){
                    $classString = GageStatus::DIPLOMAT_CLASS_STRING;
                }else{
                    $classString = GageStatus::CONSUL_CLASS_STRING;
                }
                break;
            default:
                break;
        }
        return $classString;
    }
}
