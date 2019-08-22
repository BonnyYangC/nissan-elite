<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 12:29 PM
 */

namespace App\models\role;

use App\models\User;
use App\models\role\status\IColor;
use App\models\role\status\RetailSalesConsultantStatus;

class FleetSalesExecutive extends RetailSalesConsultant
{
    public $name='fleet_sales_executive';

    public $salesVTarget   = [
        'label'=>'Sales v Target',
        'backgroundColor' => IColor::AQUA,
        'data'=>[]
    ];

    public $salesVolumeGrowth             = [
        'label'=>'Volume Growth',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public function __construct(User $user = null)
    {
        parent::__construct($user);
        $this->hasPlatinumRanking = true;
    }

    /**
     * Handle fleet sales executive's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $new=$vFleetTargetScore=$vFleetTarget=$fleetVolumeGrowthScore=$training=$sales_results=$fleetVolumeGrowth=[];
        for($i=0; $i<11; $i++) //only show from May to Mar
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                //1
                $new[]              = $this->_buildForJs($item['credit_actual_sales']);
                $sales_results[]            = $this->_buildForTableElement($item['sales'],0);
                //2
                $vFleetTargetScore[]   = $this->_buildForJs($item['v_fleet_target_score']); 
                $vFleetTarget[]   = $this->_buildForTableElement($item['v_fleet_target']*100).'%'; 
//3
                $fleetVolumeGrowthScore[]   = $this->_buildForJs($item['fleet_volumn_growth_score']); 
                $fleetVolumeGrowth[]   = $this->_buildForTableElement($item['fleet_volumn_growth']).'%'; 
//4
                $training[]         = $this->_buildForJs([$item['training'],$item['pathway'],$item['training_competency']]);

            }
            else
            {
                $new[]              = $this->_buildForJs(0);
                $vFleetTargetScore[]   = $this->_buildForJs(0);
                $fleetVolumeGrowthScore[]   = $this->_buildForJs(0);

                $training[]         = $this->_buildForJs([0,0,0]);

                $sales_results[]            = null;
                $vFleetTarget[]   = null;
                $fleetVolumeGrowth[]   = null;
            }
        }

        return [
            // For js array
            "JS_newVehicleSales"    =>$new,
            "JS_vFleetTarget" => $vFleetTargetScore,
            "JS_fleetVolumeGrowth" =>$fleetVolumeGrowthScore,

            "JS_training"           =>$training,

            // For PHP array
            "salesResult"               =>$sales_results,
            "vFleetTarget" => $vFleetTarget,
            "fleetVolumeGrowth" => $fleetVolumeGrowth,
        ];
    }

    /**
     * Get the template's name for the role
     * @return string
     */
    public function getTemplateName()
    {
        return $this->name;
    }

    public function getDashboardViewData($data, $ytdParam)
    {
        $ytd = 0;
        $dataResults = $data['Results'];
//        dd($dataResults);
        for($i=0; $i<11; $i++)//only show from May to Mar
        {
            $period=mktime(0,0,0,5+$i,1,$ytdParam);

            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($dataResults[$key]) ? $dataResults[$key] : null;

            if($item)
            {

                $ytd=$item['credit_ytd'];
                $this->JS_credits[date("M", $period)] = $item['credit_mtd'].'';

                /**
                 * From Data results
                 */
                $this->newVehicleSales['data'][] = intval($item['credit_actual_sales']);
                $this->salesVTarget['data'][]  = intval($item['v_fleet_target_score']);
                $this->salesVolumeGrowth['data'][]  = intval($item['fleet_volumn_growth_score']);
                $this->trainingData['data'][]  = $item['training'] // Online
                    + $item['pathway'] + $item['training_competency'];
                $this->incentivesForDashboard['data'][] = empty(trim($item['incentive'])) ? 0 : intval($item['incentive']);
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;

                /**
                 * From Data results
                 */
                $this->newVehicleSales['data'][]  = 0;
                $this->salesVTarget['data'][]  = 0;
                $this->salesVolumeGrowth['data'][]  = 0;
                $this->trainingData['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
        }

        // Status
        $status = new RetailSalesConsultantStatus($ytd);

        $result = [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->newVehicleSales,
                $this->salesVTarget,
                $this->salesVolumeGrowth,
                $this->trainingData,
                $this->incentivesForDashboard
            ],
            'statusChart'=>[
                'gageArray'=>$status->getGageIndicators(),
                'color'=>$status->getColor(),
                'colorText'=>$status->getColorText(),
                'toReach'=>$status->getToReach(),
                'min'=>$status->getMin(),
                'max'=>$status->getMax(),
            ],
        ];
        return $result;
    }
}