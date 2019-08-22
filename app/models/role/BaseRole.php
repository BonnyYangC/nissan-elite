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
     * Need to show the regional ranking in dashboard page
     * @var bool
     */
    public $hasPlatinumRanking = false;

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
        'backgroundColor' => IColor::LIGHT_PINK,
        'data'=>[]
    ];
    public $trainingData = [
        'label'=>'Training',
        'backgroundColor' => IColor::LIGHT_RED,
        'data'=>[]
    ];

    public $keptInformed= [
        'label'=>'Kept Informed',
        'backgroundColor' => IColor::LIGHT_PERU,
        'data'=>[]
    ];

    /**
     * Add incentives for all roles
     * @var array
     */
    public $incentivesForDashboard = [
        'label'=>'Incentive',
        'backgroundColor' => IColor::GREEN_YELLOW,
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user;
        $this->startPoint = Carbon::createFromDate(configuration('YEAR'),4,1,env('DEFAULT_TIMEZONE'));
    }

    /**
     * Setup lifeTime and excellence
     * @param $data
     * @param $period
     */
    protected function _setupLifeTimeAndExcellence($data, $period){
        //$dataResults = isset($data['Results']) ? $data['Results'] : null;
        if (isset($data[date("M-Y", $period)]))
        {
            $this->lifeTime =
                (($data[date("M-Y", $period)]['lifetime'] > 0) ?
                    $data[date("M-Y", $period)]['lifetime'] :
                    $data[date("M-Y", $period)]['credit_mtd']);
        
        //if ( !$this->excellenceResult)
        //{
            $this->excellenceResult =$data[date("M-Y", $period)]['excellence'];
        //}
        
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