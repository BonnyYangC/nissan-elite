<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 30/7/18
 * Time: 10:28 AM
 */

namespace App\models\role;

use App\models\role\status\RetailSalesConsultantStatus;
use App\models\User;

class RetailSalesConsultant extends BaseRole implements IRole
{
    public $name='retail_sales_consultant';

    public function __construct(User $user = null)
    {
        parent::__construct($user);
    }

    /**
     * Retrieve data for dashboard view
     * @param $data
     * @param $ytdParam
     * @return array
     */
    public function getDashboardViewData($data, $ytdParam)
    {
        // TODO: Implement getDashboardViewData() method.
        $ytd = 0;
        $dataResults = $data['Results'];
//        dd($dataResults);
        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,$ytdParam);

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
                $this->salesRecommendationSaturation['data'][]  = intval($item['ce_recommendation']);
                $this->followUpSaturation['data'][]  = intval($item['follow_up_credit']);
                $this->follow_up_credit_sat['data'][]  = intval($item['follow_up_credit_sat']);
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
                $this->salesRecommendationSaturation['data'][]  = 0;
                $this->followUpSaturation['data'][]  = 0;
                $this->follow_up_credit_sat['data'][]  = 0;
                $this->trainingData['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
            }

            $this->_setupLifeTimeAndExcellence($data,$period);
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
                $this->salesRecommendationSaturation,
                $this->followUpSaturation,
                $this->follow_up_credit_sat,
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
//            'rankingNationally'=> $rankingNationally,
//            'rankingRegionally'=> $myRegionallyRanking,
        ];
//        dd($result);

        return $result;
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $new=$recommendation=$FU=$FUcredSAT=$training=$sales_results=$recommendation_results=$fu_results=[];
        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                $new[]              = $this->_buildForJs($item['credit_actual_sales']);
                $recommendation[]   = $this->_buildForJs($item['ce_recommendation']);
                $FU[]               = $this->_buildForJs($item['follow_up_credit']);
                $FUcredSAT[]        = $this->_buildForJs($item['follow_up_credit_sat']);
                $training[]         = $this->_buildForJs([$item['training'],$item['pathway'],$item['training_competency']]);

                $followUpScoreSAT[]        = $this->_buildForTableElement($item['follow_up_score_sat'],0).'%';
                $sales_results[]            = $this->_buildForTableElement($item['sales'],0);
                $recommendation_results[]   = $this->_buildForTableElement($item['score_recommendation']).'%';
                $fu_results[]               = $this->_buildForTableElement($item['follow_up_score']).'%';
            }
            else
            {
                $new[]              = $this->_buildForJs(0);
                $recommendation[]   = $this->_buildForJs(0);
                $FU[]               = $this->_buildForJs(0);
                $FUcredSAT[]        = $this->_buildForJs(0);
                $followUpCreditSAT[]= $this->_buildForJs(0);
                $training[]         = $this->_buildForJs([0,0,0]);

                $sales_results[]            = null;
                $recommendation_results[]   = null;
                $fu_results[]               = null;
            }

        }
        return [
            // For js array
            "JS_newVehicleSales"    =>$new,
            "JS_reCommendation"     =>$recommendation,
            "JS_followUpCredits"    =>$FU,
            "JS_followUpCredSat"    =>$FUcredSAT,
            "JS_training"           =>$training,
            // For PHP array
            "followUpScoreSAT"     => $followUpScoreSAT,
            "salesResult"               =>$sales_results,
            "followUpCredit"             =>$kept_informed,
            "salesRecommendationResult" =>$recommendation_results,
            "followUpCredits"           =>$fu_results,
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


}
