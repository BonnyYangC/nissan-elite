<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 2:03 PM
 */

namespace App\models\role;

use App\models\User;
class ServiceAdviser
{
    private $user;

    public $name='service_adviser';

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
}