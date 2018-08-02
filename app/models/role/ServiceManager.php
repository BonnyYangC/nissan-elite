<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 10:14 AM
 */

namespace App\models\role;

use App\models\role\status\ServiceManagerStatus;
use App\models\User;
use Carbon\Carbon;

class ServiceManager extends BaseRole implements IRole
{
    public $name='service_manager';

    public function __construct(User $user = null)
    {
        parent::__construct($user);
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $recommendation=$recommendation_results=$clean=$clean_results=$fu=$fu_results=$emw=$emw_results=$training=[];
        $customerPaidRepairCredits = [];
        $customerPaidRepair = [];

        $startPoint = Carbon::createFromDate(env('YEAR'),3,1,env('DEFAULT_TIMEZONE'));

        for($i=0; $i<12; $i++)
        {
            $key = $startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                $customerPaidRepair[]   = $this->_buildForJs($startPoint, $item['cpr_credit']);
                $recommendation[]       = $this->_buildForJs($startPoint, $item['recommendation_credit']);
                $clean[]                = $this->_buildForJs($startPoint, $item['vclean_credit']);
                $fu[]                   = $this->_buildForJs($startPoint, $item['followup_credit']);
                $emw[]                  = $this->_buildForJs($startPoint, $item['emw_credit']);
                $training[]             = $this->_buildForJs($startPoint, [$item['training'],$item['classroom']]);

                $customerPaidRepairCredits[]    = $this->_buildForTableElement($item['cpr'],2);
                $recommendation_results[]       = $this->_buildForTableElement($item['recommendation']);
                $clean_results[]                = $this->_buildForTableElement($item['vclean']);
                $fu_results[]                   = $this->_buildForTableElement($item['followup']);
                $emw_results[]                  = $this->_buildForTableElement($item['emw']);
            }
            else
            {
                $customerPaidRepair[]   = $this->_buildForJs($startPoint, 0);
                $recommendation[]       = $this->_buildForJs($startPoint, 0);
                $clean[]                = $this->_buildForJs($startPoint, 0);
                $fu[]                   = $this->_buildForJs($startPoint, 0);
                $emw[]                  = $this->_buildForJs($startPoint, 0);
                $training[]             = $this->_buildForJs($startPoint, [0,0]);

                $customerPaidRepairCredits[]    = $this->_buildForTableElement();
                $recommendation_results[]       = $this->_buildForTableElement();
                $clean_results[]                = $this->_buildForTableElement();
                $fu_results[]                   = $this->_buildForTableElement();
                $emw_results[]                  = $this->_buildForTableElement();
            }

        }
        $metrics = [
            "RECOMMENDATION" => $recommendation,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            "CLEAN" => $clean,
            "CLEAN_RESULTS" => $clean_results,
            "FOLLOWUP" => $fu,
            "FOLLOWUP_RESULTS" => $fu_results,
            "EMW" => $emw,
            "EMW_RESULTS" => $emw_results,
            "TRAINING" => $training,
            "CUSTOMER_PAID_REPAIR" => $customerPaidRepair,
            "customerPaidRepairCredits" => $customerPaidRepairCredits,
        ];
        return $metrics;
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
        $aryCredits = $data['Credits'];
        $dataResults = $data['Results'];

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,$ytdParam);

            if(isset($aryCredits[date("M-Y", $period)]))
            {
                $ytd=$aryCredits[date("M-Y", $period)]['ytd'];
                $this->JS_credits[date("M", $period)] = $aryCredits[date("M-Y", $period)]['mtd'];
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][] = intval($dataResults[date("M-Y", $period)]['recommendation_credit']);
                $this->VehicleCleanliness['data'][] = intval($dataResults[date("M-Y", $period)]['vclean_credit']);
                $this->followUpPercentage['data'][]  = intval($dataResults[date("M-Y", $period)]['followup_credit']);
                $this->EMW['data'][]  = intval($dataResults[date("M-Y", $period)]['emw_credit']);
                $this->training['data'][]  = $dataResults[date("M-Y", $period)]['training']
                    + $dataResults[date("M-Y", $period)]['pathway']
                    + $dataResults[date("M-Y", $period)]['classroom'];
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][] = 0;
                $this->VehicleCleanliness['data'][]  = 0;
                $this->followUpPercentage['data'][]  = 0;
                $this->EMW['data'][]  = 0;
                $this->training['data'][]  = 0;
            }

            $this->_setupLifeTimeAndExcellence($data,$period);
        }

        // Status
        $status = new ServiceManagerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->serviceRecommendation,
                $this->VehicleCleanliness,
                $this->followUpPercentage,
                $this->EMW,
                $this->training,
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
    }

}