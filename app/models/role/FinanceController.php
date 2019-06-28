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
use Carbon\Carbon;

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
        'backgroundColor' => IColor::RED,
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
        'label'=>'Accuracy',
        'backgroundColor' => IColor::RED,
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
        $financial=$frequency_results=$ontime_results=$quality=$balance_results=$submission_results=$management=$checklist_results=$meeting_results=$training=[];
        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                //1
                $financial[]    = $this->_buildForJs( [$item['frequency_credits']] );
                $frequency_results[]    = $this->_buildForTableYesOrNoElement($item['frequency']);
                //2
                $quality[]      = $this->_buildForJs( [$item['balance_credit'], $item['quality_credit']] );
                try{
                    $sub = Carbon::createFromFormat('d-M-Y', $item['quality']);
                    $submission_results[]   = $sub->format('d/M');
                }catch (\Exception $exception){
                    $submission_results[]   = $item['quality'];
                }
                //3
                $management[]   = $this->_buildForJs( [$item['checklist_credit'], $item['meeting_credit']] );
                $checklist_results[]    = $this->_buildForTableElement($item['checklist'],0);
                $meeting_results[]      = $this->_buildForTableElement($item['meeting'],0);

                $training[]     = $this->_buildForJs( [$item['training'], $item['pathway'], $item['training_competency']] );

                //$ontime_results[]       = $this->_buildForTableYesOrNoElement($item['ontime']);
                //$balance_results[]      = $this->_buildForTableYesOrNoElement($item['balance']);



            }
            else
            {
                $financial[]    = $this->_buildForJs( [0] );
                $quality[]      = $this->_buildForJs( [0,0] );
                $management[]   = $this->_buildForJs( [0,0] );
                $training[]     = $this->_buildForJs( [0,0,0] );

                $frequency_results[]    = null;
                //$ontime_results[]       = null;
                //$balance_results[]      = null;
                $submission_results[]   = null;
                $checklist_results[]    = null;
                $meeting_results[]      = null;
            }
        }

        return [
            "FINANCIAL" => $financial,
            "FREQUENCY_RESULTS" => $frequency_results,
            "QUALITY" => $quality,
            "SUBMISSION_RESULTS" => $submission_results,
            "MANAGEMENT" => $management,
            "CHECKLIST_RESULTS" => $checklist_results,
            "MEETING_RESULTS" => $meeting_results,
            //"ONTIME_RESULTS" => $ontime_results,
            //"BALANCE_RESULTS" => $balance_results,
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

    /**
     * Generate the data for dashboard view
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
                $this->JS_credits[date("M", $period)] = $item['credit_mtd'];
                /**
                 * From Data results
                 */
                $this->Frequency['data'][] = intval($item['frequency_credits']);
                $this->Ontime['data'][] = intval($item['ontime_credits']);
                $this->Balance['data'][]  = intval($item['balance_credit']);
                $this->Quality['data'][]  = intval($item['quality_credit']);
                $this->Checklist['data'][]  = intval($item['checklist_credit']);
                $this->Meetings['data'][]  = intval($item['meeting_credit']);
                $this->trainingData['data'][]  = $item['training'] ? $item['training'] : 0;
                $this->incentivesForDashboard['data'][] = isset($item['incentive']) && !empty(trim($item['incentive'])) ? intval($item['incentive']) : 0;
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
                $this->trainingData['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
        }

        // Status
        $status = new FinanceControllerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->Frequency,
                //$this->Ontime,
                $this->Quality,
                $this->Checklist,
                $this->Meetings,
                $this->trainingData,
                $this->incentivesForDashboard
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