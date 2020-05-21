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
use App\models\role\status\IColor;

class SalesManager extends BaseRole implements IRole
{
    public $name='sales_manager';
//Matched Ow
    public $matchedOW = [
        'label'=>'Matched OW',
        'backgroundColor' => IColor::BRONZE,
        'data'=>[]
    ];
//Retail Forecast
    public $retailForecast = [
        'label'=>'Forecast',
        'backgroundColor' => IColor::SILVER,
        'data'=>[]
    ];
//Sales Overall Satisfaction
    public $DlrRec = [
        'label'=>'Overall Sat',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
//apnur
    public $apnur = [
        'label'=>'APNUR',
        'backgroundColor' => IColor::LIGHT_GREEN,
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        parent::__construct($user);
        $this->hasPlatinumRanking = false;
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $matched=$new=$sos=$sos_results=$retail=$training=$matched_results=$sales_results=$kid=$kid_results=$retail_results=$apnur=[];
        //$apnur = [[],[],[]];

        for($i=0; $i<12; $i++) 
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                //1
                $matched[] = $this->_buildForJs($item['order_write_credit']);
                $matched_results[]    = $this->_buildForTableElement($item['order_write_variation'],0);

                //2
                $new[] = $this->_buildForJs($item['actual_sales']);
                $sales_results[]    = $this->_buildForTableElement($item['percent'],0).'%';

                //3
                $sos[] = $this->_buildForJs($item['sos_credit']);
                $sos_results[] = $this->_buildForTableElement($item['sos'],1);

                //4
                $kid[] = $this->_buildForJs($item['kid_credit']);
                $kid_results[]       = $this->_buildForTableElement($item['kid'],1);

                //5
                $retail[] = $this->_buildForJs($item['retail_credit']);
                $retail_results[]   = is_null($item['retail_percentage']) ? null : ($item['retail_percentage']>0 ? 'YES' : 'NO');

                //6
                $apnur[] = $this->_buildForJs([$item['points_apnur_n'],$item['points_apnur_x'],$item['points_apnur_q']]);
                $apnur_n_results[] = $this->_buildForTableElement($item['percent_apnur_n'],1).'%';
                $apnur_x_results[] = $this->_buildForTableElement($item['percent_apnur_x'],1).'%';
                $apnur_q_results[] = $this->_buildForTableElement($item['percent_apnur_q'],1).'%';

                //7
                $training[]         = $this->_buildForJs([$item['training'],$item['pathway'],$item['training_competency'],$item['training_bonus']]);
            }
            else
            {
                $matched[] = $this->_buildForJs(0);
                $new[] = $this->_buildForJs(0);
                $sos[] = $this->_buildForJs(0);
                $kid[] = $this->_buildForJs(0);
                $retail[] = $this->_buildForJs(0);
                $training[] = $this->_buildForJs([0,0,0,0]);
                $apnur[] = $this->_buildForJs([0,0,0]);

                $apnur_n_results[] = null;
                $apnur_x_results[] = null;
                $apnur_q_results[] = null;

                $matched_results[] = null;
                $sales_results[] = null;
                $sos_results[] = null;
                $kid_results[] = null;

                $retail_results[] = null;
            }            
        }

        $result = [
            "MATCHED_OW" => $matched,
            "MATCHED_OW_RESULTS" => $matched_results,
            "NEW_VEHICLE_SALES" => $new,
            "SALES_RESULTS" => $sales_results,
            "JS_SOS" => $sos,
            "SOS_RESULTS" => $sos_results,
            "JS_KID" => $kid,
            "KID_RESULTS" => $kid_results,
            "JS_RETAIL" => $retail,
            "RETAIL_RESULTS" => $retail_results,
            "APNUR" => $apnur,
            "APNUR_N_RESULTS" => $apnur_n_results,
            "APNUR_X_RESULTS" => $apnur_x_results,
            "APNUR_Q_RESULTS" => $apnur_q_results,
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
                $this->keptInformed['data'][] = intval($item['kid_credit']);
                $this->DlrRec['data'][]             = intval($item['sos_credit']);
                $this->retailForecast['data'][]     = intval($item['retail_credit']);
                $this->apnur['data'][]              = 
                    intval($item['points_apnur_n']) + 
                    intval($item['points_apnur_q']) + 
                    intval($item['points_apnur_x']);
                $this->trainingData['data'][]           = $item['training']
                    + $item['pathway']
                    + $item['training_competency']
                    + $item['training_bonus'];
                $this->incentivesForDashboard['data'][] = isset($item['incentive']) && !empty(trim($item['incentive'])) ? intval($item['incentive']) : 0;
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;
                /**
                 * From Data results
                 */
                $this->matchedOW['data'][] = 0;
                $this->newVehicleSales['data'][]  = 0;
                $this->keptInformed['data'][]  = 0;
                $this->DlrRec['data'][]  = 0;
                $this->retailForecast['data'][]  = 0;
                $this->apnur['data'][] = 0;
                $this->trainingData['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
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
            'apnur'         =>$this->apnur,
            'metricsCurrentStatus'   =>[
                $this->matchedOW,
                $this->newVehicleSales,
                $this->DlrRec,
                $this->keptInformed,
                $this->retailForecast,
                $this->apnur,
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

