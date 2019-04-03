<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/7/18
 * Time: 3:31 PM
 */

namespace App\models\role;

use App\models\BaseModel;
use App\models\role\status\IColor;
use App\models\User;
use Carbon\Carbon;

class BaseRole extends BaseModel
{
    protected $user;

    /**
     * @var Carbon $startPoint
     * To generate the array's key when iterate the metrics data
     */
    protected $startPoint = null;

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
    public $excellenceResult = null;
    public $newVehicleSales = [
        'label'=>'New Vehicle Sales',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $salesRecommendationSaturation   = [
        'label'=>'CE Satisfaction',
        'backgroundColor' => IColor::RED, // dark grey
        'data'=>[]
    ];
    public $followUpSaturation             = [
        'label'=>'Kept Informed',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];

                            public $newThing             = [
                                'label'=>'New thing',
                                'backgroundColor' => IColor::Platinum,
                                'data'=>[]
                            ];

    public $trainingData = [
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
        'label'=>'CE Sat',
        'backgroundColor' => IColor::RED,
        'data'=>[]
    ];
    public $middleMonth = [
        'label'=>'Forecast',
        'backgroundColor' => IColor::LIGHT_GREY,
        'data'=>[]
    ];

    /**
     * Add incentives for all roles
     * @var array
     */
    public $incentivesForDashboard = [
        'label'=>'Incentive',
        'backgroundColor' => IColor::DARK_GREEN,
        'data'=>[]
    ];

    // Service adviser: start
    public $serviceRecommendation = [
        'label'=>'Service Satisfaction',
        'backgroundColor' => IColor::RED,
        'data'=>[]
    ];
    public $advice = [
        'label'=>'Advice',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $VehicleCleanliness = [
        'label'=>'Value for Money',
        'backgroundColor' => IColor::GAINS_BORO,
        'data'=>[]
    ];
    public $EMW = [
        'label'=>'EMW',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public $FFT = [
        'label'=>'FFT',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $SERVICE_YOU_CAN_TRUST = [
        'label'=>'AYCT',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $CUSTOMER_REPAIR_ORDER = [
        'label'=>'CPR',
        'backgroundColor' => IColor::GAINS_BORO,
        'data'=>[]
    ];
    // Service adviser: end

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user;
        $this->startPoint = Carbon::createFromDate(env('YEAR'),3,1,env('DEFAULT_TIMEZONE'));
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

        if ( !$this->excellenceResult)
        {
            $this->excellenceResult =$data[date("M-Y", $period)]['excellence'];
        }
    }

    /**
     * @param Carbon $carbon
     * @param $values
     * @return array
     */
    protected function _buildForJs($values, Carbon $carbon = null){
        $carbon = $carbon ? $carbon : $this->startPoint;
        if(is_null($carbon)){
            return [];
        }

        $result = [
            $carbon->format('M'),
        ];
        if(is_array($values)){
            foreach ($values as $value) {
                $result[] = floatval($value);
            }
        }else{
            $result[] = floatval($values);
        }
        return $result;
    }

    /**
     * @param null $value
     * @param int $demicals
     * @return float|string
     */
    protected function _buildForTableElement($value = null, $demicals = 1){
        return $value ? number_format(floatval($value),$demicals) : 0.0;
    }

    /**
     * @param null $value
     * @return string
     */
    protected function _buildForTableYesOrNoElement($value){
        return $value == '1' ? 'YES' : 'NO';
    }
}