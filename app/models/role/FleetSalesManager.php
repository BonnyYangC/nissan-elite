<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 12:29 PM
 */

namespace App\models\role;

use App\models\User;
class FleetSalesManager
{
    private $user;

    public $name='fleet_sales_manager';

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

        $new=$recommendation=$FU=$training=$matched_results=$sales_results=$recommendation_results=$fu_results='';
        $class='nissangray-light-back';
        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['credit_actual_sales'] . "]";
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['ce_recommendation'] . "]";
                $FU.=(empty($FU) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['follow_up_credit'] . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['pathway'] . "," .  $data[date("M-Y", $period)]['training'] . "," .  $data[date("M-Y", $period)]['classroom'] . "]";

                $sales_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['sales'] . '</td>';
                $recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_recommendation'] . '</td>';
                $fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['follow_up_score'] . '</td>';
            }
            else
            {
                $new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $FU.=(empty($FU) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";

                $sales_results.='<td class="' . $class . '">&nbsp;</td>';
                $recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
                $fu_results.='<td class="' . $class . '">&nbsp;</td>';

            }

        }

        return [
            "NEW_VEHICLE_SALES" => $new,
            "SALES_RECOMMENDATION" => $recommendation,
            "FOLLOW_UP_CREDITS" => $FU,
            "SALES_RESULTS" => $sales_results,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            "FOLLOWUP_RESULTS" => $fu_results,
            "TRAINING" => $training
        ];
    }
}