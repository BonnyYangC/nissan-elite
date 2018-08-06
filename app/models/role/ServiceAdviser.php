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
        $advice=$advice_results=$emw=$emw_results=$recommendation=$recommendation_results=$fu=$fu_results=$training=$cpr=$cpr_result='';

        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                $recommendation[] = $this->_buildForJs($item['trust_credit']?$item['trust_credit']:0);
                $emw[] = $this->_buildForJs($item['emw_credit']?$item['emw_credit']:0);
                $advice[] = $this->_buildForJs($item['recom_credit']?$item['recom_credit']:0);
                $fu[] = $this->_buildForJs($item['fu_credit']?$item['fu_credit']:0);
                $cpr[] = $this->_buildForJs($item['cpr']?$item['cpr']:0);
                $training[] = $this->_buildForJs([$item['training']?$item['training']:0,$item['classroom']?$item['classroom']:0]);

                $advice_results[] = $this->_buildForTableElement($item['trust_score']);
                $emw_results[] = $this->_buildForTableElement($item['emw_score'],0);
                $recommendation_results[] = $this->_buildForTableElement($item['recom_score']);
                $fu_results[] = $this->_buildForTableElement($item['fu_score']);
                $cpr_result[] = $this->_buildForTableElement($item['cpr_credit']);
            }
            else
            {
                $recommendation[]   = $this->_buildForJs(0);
                $emw[]              = $this->_buildForJs(0);
                $advice[]           = $this->_buildForJs(0);
                $fu[]               = $this->_buildForJs(0);
                $cpr[]               = $this->_buildForJs(0);
                $training[]   = $this->_buildForJs([0,0]);

                $advice_results[]           = null;
                $emw_results[]              = null;
                $recommendation_results[]   = null;
                $fu_results[]               = null;
                $cpr_result[]               = null;
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
            // New field of 2018
            "CPR" => $cpr,
            "CPR_RESULT" => $cpr_result,
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