<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 10:15 AM
 */

namespace App\models\role;
use App\models\role\status\SalesManagerStatus;
use App\models\User;

class SalesManager extends BaseRole implements IRole
{
    public $name='sales_manager';

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
        $matched=$new=$recommendations=$followup=$retail=$training=$matched_results=$sales_results=$recommendation_results=$fu_results=$retail_results='';

        $class='nissangray-light-back';

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['order_write_credit'] . "]";
                $new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['actual_sales'] . "]";
                $recommendations.=(empty($recommendations) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['ce_recomendation']  . "]";
                $followup.=(empty($followup) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['follow_up_ce'] . "]";
                $retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['retail_midmth'] . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "," . $data[date("M-Y", $period)]['pathway'] . "," . $data[date("M-Y", $period)]['classroom']  . "]";


                $matched_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['order_write_variation'] . '</td>';
                $sales_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['percent'] . '%</td>';
                $recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_recommendation'] . '</td>';
                $fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['follow_up_score'] . '</td>';
                $retail_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['retail_percentage']*100 . '%</td>';
            }
            else
            {
                $matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $recommendations.=(empty($recommendations) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $followup.=(empty($followup) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";

                $matched_results.='<td class="' . $class . '">&nbsp;</td>';
                $sales_results.='<td class="' . $class . '">&nbsp;</td>';
                $recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
                $fu_results.='<td class="' . $class . '">&nbsp;</td>';
                $retail_results.='<td class="' . $class . '">&nbsp;</td>';

            }

        }

        $result = [
            "MATCHED_OW" => $matched,
            "MATCHED_OW_RESULTS" => $matched_results,
            "NEW_VEHICLE_SALES" => $new,
            "SALES_RESULTS" => $sales_results,
            "RECOMMENDATIONS" => $recommendations,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            "FOLLOW_UP" => $followup,
            "FU_RESULTS" => $fu_results,
            "MIDMTH_RETAIL" => $retail,
            "RETAIL_RESULTS" => $retail_results,
            "TRAINING" => $training
        ];

        return $result;
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

        /**
         * 开始确认并查找当前用户的名次: Region and National
         */
        $myRegionallyRanking = isset($data['MyRanking']) && $data['MyRanking']
            ? $data['MyRanking'] : $data['Regional'];

        $rankingNationally = null;
        if(isset($data['Rankings']) && !empty($data['Rankings'])){
            // 从 ranking 的表格里循环查找, 直到确定自己的名次
            foreach ($data['Rankings'] as $index => $ranking) {
                if($ranking['member_id'] == $this->user->getEmployeeCode()){
                    $rankingNationally = $index + 1;
                    break;
                }
            }
        }
        /**
         * 开始确认并查找当前用户的名次: End
         */

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
                $this->matchedOW['data'][] = intval($dataResults[date("M-Y", $period)]['order_write_credit']);
                $this->newVehicleSales['data'][] = intval($dataResults[date("M-Y", $period)]['actual_sales']);
                $this->followUpPercentage['data'][]  = intval($dataResults[date("M-Y", $period)]['follow_up_ce']);
                $this->DlrRec['data'][]  = intval($dataResults[date("M-Y", $period)]['ce_recomendation']);
                $this->middleMonth['data'][]  = intval($dataResults[date("M-Y", $period)]['retail_midmth']);
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
                $this->matchedOW['data'][] = 0;
                $this->newVehicleSales['data'][]  = 0;
                $this->followUpPercentage['data'][]  = 0;
                $this->DlrRec['data'][]  = 0;
                $this->middleMonth['data'][]  = 0;
                $this->training['data'][]  = 0;
            }

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

        // Status
        $status = new SalesManagerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->matchedOW,
                $this->newVehicleSales,
                $this->DlrRec,
                $this->followUpPercentage,
                $this->middleMonth,
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
            'rankingNationally'=> $rankingNationally,
            'rankingRegionally'=> $myRegionallyRanking,
        ];
    }
}