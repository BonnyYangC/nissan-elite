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
        $advice=$advice_results=$emw=$emw_results=$recommendation=$recommendation_results=$fu=$fu_results=$training=$cpr=$cpr_result=[];

        $valueForMoney = $valueForMoneyTable = '';

        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                $recommendation[] = $this->_buildForJs($item['recom_credit']?$item['recom_credit']:0);
                $recommendation_results[] = $this->_buildForTableElement($item['recom_score']).'%';

                $emw[] = $this->_buildForJs($item['emw_credit']?$item['emw_credit']:0);

                $advice[] = $this->_buildForJs($item['trust_credit']?$item['trust_credit']:0);
                $advice_results[] = $this->_buildForTableElement($item['trust_score']).'%';

                $valueForMoney[] = $this->_buildForJs($item['fu_credit']?$item['fu_credit']:0);
                $valueForMoneyTable[] = $this->_buildForTableElement($item['fu_score']).'%';

                $cpr[] = $this->_buildForJs($item['cpr_credit']?$item['cpr_credit']:0);
                $training[] = $this->_buildForJs([$item['training']?$item['training']:0,$item['classroom']?$item['classroom']:0]);


                $emw_results[] = $this->_buildForTableElement($item['emw_score'],0);


                $cpr_result[] = $this->_buildForTableElement($item['cpr']*100,1).'%';
            }
            else
            {
                $valueForMoney[]   = $this->_buildForJs(0);
                $valueForMoneyTable[]   = null;
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
                $cpr_result[]               = '';
            }
        }

        return [
            "RECOMMENDATION" => $recommendation,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            "VALUE_FOR_MONEY" => $valueForMoney,
            "VALUE_FOR_MONEY_TABLE" => $valueForMoneyTable,
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

    /**
     * Retrieve data for dashboard view
     * @param $data
     * @param $ytdParam
     * @return array
     */
    public function getDashboardViewData($data, $ytdParam)
    {
        $ytd = 0;
        $dataResults = $data['Results'];

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,$ytdParam);
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($dataResults[$key]) ? $dataResults[$key] : null;

            if($item)
            {
                $ytd=$item['credit_ytd'];
                $this->JS_credits[date("M", $period)] = $item['credit_mtd']?$item['credit_mtd']:0;
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][]  = intval($item['recom_credit']);
                $this->VehicleCleanliness['data'][]     = intval($item['fu_credit']);
                $this->SERVICE_YOU_CAN_TRUST['data'][]     = intval($item['trust_credit']);
                $this->EMW['data'][]                    = intval($item['emw_credit']);
                $this->training['data'][]               = $item['training']
                    + $item['pathway']
                    + $item['classroom'];
                $this->CUSTOMER_REPAIR_ORDER['data'][]  = $item['cpr_credit'];
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;
                /**
                 * From Data results
                 */
                $this->serviceRecommendation['data'][] = 0;
                $this->VehicleCleanliness['data'][]  = 0;
                $this->SERVICE_YOU_CAN_TRUST['data'][]  = 0;
                $this->EMW['data'][]  = 0;
                $this->training['data'][]  = 0;
                $this->CUSTOMER_REPAIR_ORDER['data'][]  = 0;
            }

            $this->_setupLifeTimeAndExcellence($data,$period);
        }

        // Status
        $status = new ServiceAdviserStatus($ytd);

        return  [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->serviceRecommendation,
                $this->VehicleCleanliness,
                $this->SERVICE_YOU_CAN_TRUST,
                $this->CUSTOMER_REPAIR_ORDER,
                $this->EMW,
                $this->training,
            ],
//             'metricsCurrentStatus'   =>[
//                $this->matchedOW,
//                $this->newVehicleSales,
//                $this->DlrRec,
//                $this->followUpPercentage,
//                $this->middleMonth,
//                $this->training,
//            ],
            'statusChart'=>[
                'gageArray'=>$status->getGageIndicators(),
                'color'=>$status->getColor(),
                'colorText'=>$status->getColorText(),
                'toReach'=>$status->getToReach(),
                'min'=>$status->getMin(),
                'max'=>$status->getMax(),
            ],
        ];

//        return [
//            // For js array
//            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
//            // For PHP array
//            "lifeTime"      =>$this->lifeTime,
//            "excellence"    =>$this->excellenceResult,
//            "ytd"           =>$ytd,
//            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
//            'metricsCurrentStatus'   =>[
//                $this->serviceRecommendation,
//                $this->VehicleCleanliness,
//                $this->FFT,
//
//                $this->CUSTOMER_REPAIR_ORDER,
//                $this->EMW,
//                $this->training,
//            ],
//            'statusChart'=>[
//                'gageArray'=>$status->getGageIndicators(),
//                'color'=>$status->getColor(),
//                'colorText'=>$status->getColorText(),
//                'toReach'=>$status->getToReach(),
//                'min'=>$status->getMin(),
//                'max'=>$status->getMax(),
//            ],
//        ];
    }
}