<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 2:03 PM
 */

namespace App\models\role;

use App\models\role\status\IColor;
use App\models\role\status\ServiceAdviserStatus;
use App\models\User;
class ServiceAdviser extends BaseRole implements IRole
{
    public $name='service_adviser';

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
        $advice=$advice_results=$emw=$emw_results=$recommendation=$recommendation_results=$fu=$fu_results=$training='';
        $class='nissangray-light-back';

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['trust_credit']) ? '0' : $data[date("M-Y", $period)]['trust_credit']) . "]";
                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['emw_credit']) ? '0' : $data[date("M-Y", $period)]['emw_credit']) . "]";
                $advice.=(empty($advice) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['recom_credit']) ? '0' : $data[date("M-Y", $period)]['recom_credit']) . "]";
                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['fu_credit']) ? '0' : $data[date("M-Y", $period)]['fu_credit']) . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['training']) ? '0' : $data[date("M-Y", $period)]['training']) . "," .  (empty($data[date("M-Y", $period)]['classroom']) ? '0' : $data[date("M-Y", $period)]['classroom']) ."]";


                $advice_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['trust_score'] . '</td>';
                $emw_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['emw_score'],0) . '</td>';
                $recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['recom_score'] . '</td>';
                $fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['fu_score'] . '</td>';
            }
            else
            {
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $advice.=(empty($advice) ? '' : ',') . "['" . date("M", $period) . ",',0]";
                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0]";

                $advice_results.='<td class="' . $class . '">&nbsp;</td>';
                $emw_results.='<td class="' . $class . '">&nbsp;</td>';
                $recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
                $fu_results.='<td class="' . $class . '">&nbsp;</td>';

            }
        }

        return [
            "RECOMMENDATION" => $recommendation,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            "ADVICE" => $advice,
            "ADVICE_RESULTS" => $advice_results,
            "EMW" => $emw,
            "EMW_RESULTS" => $emw_results,
            "FOLLOW_UP" => $fu,
            "FOLLOW_UP_RESULTS" => $fu_results,
            "TRAINING" => $training,
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

            $this->_setupLifeTimeAndExcellence($data,$period);
        }

        // Status
        $status = new ServiceAdviserStatus($ytd);

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
        ];
    }
}