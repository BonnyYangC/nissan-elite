<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 10:15 AM
 */

namespace App\models\role;
use App\models\User;

class SalesManager
{
    private $user;

    public $name='sales_manager';

    public function __construct(User $user = null)
    {
        $this->user = $user;
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

        return [
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
    }
}