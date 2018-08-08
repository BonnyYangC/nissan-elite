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
        $matched=$new=$recommendations=$followup=$retail=$training=$matched_results=$sales_results=$recommendation_results=$fu_results=$retail_results=[];
        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                $matched[] = $this->_buildForJs($item['order_write_credit']);
                $new[] = $this->_buildForJs($item['actual_sales']);
                $recommendations[] = $this->_buildForJs($item['ce_recomendation']);
                $followup[] = $this->_buildForJs($item['follow_up_ce']);
                $retail[] = $this->_buildForJs($item['retail_midmth']);
                $training[]         = $this->_buildForJs([$item['pathway'],$item['training'],$item['classroom']]);

                $matched_results[]  = $this->_buildForTableElement($item['order_write_variation']);
                $sales_results[]    = $this->_buildForTableElement($item['percent'],0).'%';
                $recommendation_results[] = $this->_buildForTableElement($item['score_recommendation'],0).'%';
                $fu_results[]       = $this->_buildForTableElement($item['follow_up_score'],0).'%';
                $retail_results[]   = $this->_buildForTableElement($item['retail_percentage']*100,0).'%';
            }
            else
            {
                $matched[] = $this->_buildForJs(0);
                $new[] = $this->_buildForJs(0);
                $recommendations[] = $this->_buildForJs(0);
                $followup[] = $this->_buildForJs(0);
                $retail[] = $this->_buildForJs(0);
                $training[]         = $this->_buildForJs([0,0,0]);

                $matched_results[] = null;
                $sales_results[] = null;
                $recommendation_results[] = null;
                $fu_results[] = null;
                $retail_results[] = null;
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
                $ytd = $item['credit_ytd'];
                $this->JS_credits[date("M", $period)] = $item['credit_mtd'];
                /**
                 * From Data results
                 */
                $this->matchedOW['data'][]          = intval($item['order_write_credit']);
                $this->newVehicleSales['data'][]    = intval($item['actual_sales']);
                $this->followUpPercentage['data'][] = intval($item['follow_up_ce']);
                $this->DlrRec['data'][]             = intval($item['ce_recomendation']);
                $this->middleMonth['data'][]        = intval($item['retail_midmth']);
                $this->training['data'][]           = $item['training']
                    + $item['pathway']
                    + $item['classroom'];
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
        $status = new SalesManagerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
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