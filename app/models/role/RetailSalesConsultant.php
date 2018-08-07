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
        $aryCredits = $data['Credits'];
        $dataResults = $data['Results'];

        /**
         * 开始确认并查找当前用户的名次: Region and National
         */
//        $myRegionallyRanking = isset($data['MyRanking']) && $data['MyRanking']
//            ? $data['MyRanking'] : null;
//
//        $rankingNationally = null;
//        if(isset($data['Rankings']) && !empty($data['Rankings'])){
//            // 从 ranking 的表格里循环查找, 直到确定自己的名次
//            foreach ($data['Rankings'] as $index => $ranking) {
//                if($ranking['member_id'] == $this->user->getEmployeeCode()){
//                    $rankingNationally = $index + 1;
//                    break;
//                }
//            }
//        }
        /**
         * 开始确认并查找当前用户的名次: End
         */
//        dump($dataResults);

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
                $this->training['data'][]  = $item['training']
                    + $item['pathway']
                    + $item['classroom'];
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
                $this->training['data'][]  = 0;
            }

            $this->_setupLifeTimeAndExcellence($data,$period);
        }

        // Status
        $status = new RetailSalesConsultantStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->newVehicleSales,
                $this->salesRecommendationSaturation,
                $this->followUpSaturation,
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
//            'rankingNationally'=> $rankingNationally,
//            'rankingRegionally'=> $myRegionallyRanking,
        ];
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $new=$recommendation=$FU=$training=$sales_results=$recommendation_results=$fu_results=[];
        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                $new[]              = $this->_buildForJs($item['credit_actual_sales']);
                $recommendation[]   = $this->_buildForJs($item['ce_recommendation']);
                $FU[]               = $this->_buildForJs($item['follow_up_credit']);
                $training[]         = $this->_buildForJs([$item['pathway'],$item['training'],$item['classroom']]);

                $sales_results[]            = $this->_buildForTableElement($item['sales']);
                $recommendation_results[]   = $this->_buildForTableElement($item['score_recommendation']);
                $fu_results[]               = $this->_buildForTableElement($item['follow_up_score']);
            }
            else
            {
                $new[]              = $this->_buildForJs(0);
                $recommendation[]   = $this->_buildForJs(0);
                $FU[]               = $this->_buildForJs(0);
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
            "JS_training"           =>$training,
            // For PHP array
            "salesResult"               =>$sales_results,
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