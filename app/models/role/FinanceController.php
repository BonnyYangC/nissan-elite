<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 11:33 AM
 */

namespace App\models\role;

use App\models\User;
class FinanceController
{
    /**
     * @var User
     */
    private $user;

    public $name='finance_controller';

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Handle finance controller's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $financial=$frequency_results=$ontime_results=$quality=$balance_results=$submission_results=$management=$checklist_results=$meeting_results=$training='';
        $class='nissangray-light-back';

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $financial.=(empty($financial) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['frequency_credits'] . "," . $data[date("M-Y", $period)]['ontime_credits'] . "]";
                $quality.=(empty($quality) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['balance_credit'] . "," . $data[date("M-Y", $period)]['quality_credit'] . "]";
                $management.=(empty($management) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['checklist_credit'] . "," . $data[date("M-Y", $period)]['meeting_credit'] . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "," . $data[date("M-Y", $period)]['classroom'] . "]";


                $frequency_results.='<td class="' . $class . '">' . ($data[date("M-Y", $period)]['frequency']==1 ? "YES" : "NO") . '</td>';
                $ontime_results.='<td class="' . $class . '">' . ($data[date("M-Y", $period)]['ontime']==1 ? "YES" : "NO") . '</td>';
                $balance_results.='<td class="' . $class . '">' . ($data[date("M-Y", $period)]['balance']==1 ? "YES" : "NO") . '</td>';
                $submission_results.='<td class="' . $class . '"><span class="sm">' . (empty($data[date("M-Y", $period)]['quality']) ? '' : date("d-M", strtotime($data[date("M-Y", $period)]['quality']))) . '</span></td>';
                $checklist_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['checklist'],0) . '</td>';
                $meeting_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['meeting'],0) . '</td>';
            }
            else
            {
                $financial.=(empty($financial) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
                $quality.=(empty($quality) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
                $management.=(empty($management) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0]";

                $frequency_results.='<td class="' . $class . '">&nbsp;</td>';
                $ontime_results.='<td class="' . $class . '">&nbsp;</td>';
                $balance_results.='<td class="' . $class . '">&nbsp;</td>';
                $submission_results.='<td class="' . $class . '">&nbsp;</td>';
                $checklist_results.='<td class="' . $class . '">&nbsp;</td>';
                $meeting_results.='<td class="' . $class . '">&nbsp;</td>';
            }
        }

        return [
            "FINANCIAL" => $financial,
            "FREQUENCY_RESULTS" => $frequency_results,
            "ONTIME_RESULTS" => $ontime_results,
            "QUALITY" => $quality,
            "BALANCE_RESULTS" => $balance_results,
            "SUBMISSION_RESULTS" => $submission_results,
            "MANAGEMENT" => $management,
            "CHECKLIST_RESULTS" => $checklist_results,
            "MEETING_RESULTS" => $meeting_results,
            "TRAINING" => $training
        ];
    }
}