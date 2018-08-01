<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/7/18
 * Time: 3:31 PM
 */

namespace App\models\role;

use App\models\role\status\IColor;
use App\models\User;
class BaseRole
{
    protected $user;

    /**
     * Metrics data
     * @var array
     */
    public $JS_newVehicleSales = [];
    public $JS_reCommendation  = [];
    public $JS_followUpCredits = [];
    public $JS_training        = [];
    public $salesResult                 = [];
    public $salesRecommendationResult   = [];
    public $followUpCredits             = [];

    /**
     * Dashboard data
     * @var array
     */
    public $credits = [];
    public $JS_credits = [];
    public $lifeTime = null;
    public $excellence = null;
    public $newVehicleSales = [
        'label'=>'New Vehicle Sales',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $salesRecommendationSaturation   = [
        'label'=>'Sales Recommendation R6M',
        'backgroundColor' => IColor::DARK_GREY, // dark grey
        'data'=>[]
    ];
    public $followUpSaturation             = [
        'label'=>'Follow Up R6M',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];
    public $training = [
        'label'=>'Training',
        'backgroundColor' => IColor::LIGHT_RED,
        'data'=>[]
    ];
    public $followUpPercentage= [
        'label'=>'Follow Up %',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];
    public $matchedOW = [
        'label'=>'Matched OW',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $DlrRec = [
        'label'=>'Dlr Rec',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public $middleMonth = [
        'label'=>'Mid Mth',
        'backgroundColor' => IColor::LIGHT_GREY,
        'data'=>[]
    ];

    // Service adviser: start
    public $serviceRecommendation = [
        'label'=>'Service Recommendation',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $advice = [
        'label'=>'Advice',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $VehicleCleanliness = [
        'label'=>'Vehicle Cleanliness',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];
    public $EMW = [
        'label'=>'EMW',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    // Service adviser: end

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Setup lifeTime and excellence
     * @param $data
     * @param $period
     */
    protected function _setupLifeTimeAndExcellence($data, $period){
        $dataResults = isset($data['Results']) ? $data['Results'] : null;
        if (isset($dataResults[date("M-Y", $period)]))
        {
            $this->lifeTime =
                (isset($dataResults[date("M-Y", $period)]['lifetime']) ?
                    $dataResults[date("M-Y", $period)]['lifetime'] :
                    $dataResults[date("M-Y", $period)]['credit_mtd']);
        }

        if ( !$this->excellence)
        {
            $this->excellence =$data[date("M-Y", $period)]['excellence'];
        }
    }
}