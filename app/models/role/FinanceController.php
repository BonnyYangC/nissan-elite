<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 11:33 AM
 */

namespace App\models\role;

use App\models\role\status\FinanceControllerStatus;
use App\models\role\status\IColor;
use App\models\User;
class FinanceController extends BaseRole implements IRole
{
    public $name='finance_controller';

    public $Frequency = [
        'label'=>'Frequency',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $Ontime = [
        'label'=>'Ontime',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $Balance = [
        'label'=>'Balance',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];
    public $Quality = [
        'label'=>'Quality',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public $Checklist = [
        'label'=>'Checklist',
        'backgroundColor' => IColor::LIGHT_GREY,
        'data'=>[]
    ];
    public $Meetings = [
        'label'=>'Meetings',
        'backgroundColor' => IColor::GAINS_BORO,
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        parent::__construct($user);
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
                $this->Frequency['data'][] = intval($dataResults[date("M-Y", $period)]['frequency_credits']);
                $this->Ontime['data'][] = intval($dataResults[date("M-Y", $period)]['ontime_credits']);
                $this->Balance['data'][]  = intval($dataResults[date("M-Y", $period)]['balance_credit']);
                $this->Quality['data'][]  = intval($dataResults[date("M-Y", $period)]['quality_credit']);
                $this->Checklist['data'][]  = intval($dataResults[date("M-Y", $period)]['checklist_credit']);
                $this->Meetings['data'][]  = intval($dataResults[date("M-Y", $period)]['meeting_credit']);
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
                $this->Frequency['data'][] = 0;
                $this->Ontime['data'][]  = 0;
                $this->Balance['data'][]  = 0;
                $this->Quality['data'][]  = 0;
                $this->Checklist['data'][]  = 0;
                $this->Meetings['data'][]  = 0;
                $this->training['data'][]  = 0;
            }

            $this->_setupLifeTimeAndExcellence($data,$period);
        }

        // Status
        $status = new FinanceControllerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->Frequency,
                $this->Ontime,
                $this->Balance,
                $this->Quality,
                $this->Checklist,
                $this->Meetings,
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