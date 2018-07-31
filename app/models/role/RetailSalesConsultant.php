<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 30/7/18
 * Time: 10:28 AM
 */

namespace App\models\role;

use App\models\role\status\RetailSalesConsultantStatus;
use App\models\User;
use Zend\Json\Json;

class RetailSalesConsultant implements IRole
{
    private $user;

    public $name='retail_sales_consultant';

    /**
     * Metrics data
     * @var array
     */
    public $JS_newVehicleSales = [];
    public $JS_reCommendation  = [];
    public $JS_followUpCredits = [];
    public $JS_training        = [];
    public $salesResult                 = [];
    public $salesRecommendationResult   = [];
    public $followUpCredits             = [];

    /**
     * Dashboard data
     * @var array
     */
    public $credits = [];
    public $JS_credits = [];
    public $lifeTime = null;
    public $excellence = null;
    public $newVehicleSales = [
        'label'=>'New Vehicle Sales',
        'backgroundColor' => 'black',
        'data'=>[]
    ];
    public $salesRecommendationSaturation   = [
        'label'=>'Sales Recommendation R6M',
        'backgroundColor' => 'darkgrey',
        'data'=>[]
    ];
    public $followUpSaturation             = [
        'label'=>'Follow Up R6M',
        'backgroundColor' => 'midgrey',
        'data'=>[]
    ];
    public $training = [
        'label'=>'Training',
        'backgroundColor' => 'lightred',
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    public function getDashboardViewData($data, $ytdParam)
    {
        // TODO: Implement getDashboardViewData() method.
        $new=$sr=$fu='';
        $mm='';

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
                $this->newVehicleSales['data'][] = intval($dataResults[date("M-Y", $period)]['credit_actual_sales']);
                $this->salesRecommendationSaturation['data'][]  = intval($dataResults[date("M-Y", $period)]['ce_recommendation']);
                $this->followUpSaturation['data'][]  = intval($dataResults[date("M-Y", $period)]['follow_up_credit']);
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
                $this->newVehicleSales['data'][]  = 0;
                $this->salesRecommendationSaturation['data'][]  = 0;
                $this->followUpSaturation['data'][]  = 0;
                $this->training['data'][]  = 0;
            }

            if (isset($data[date("M-Y", $period)]))
            {
                $this->lifeTime =(isset($data[date("M-Y", $period)]['lifetime']) ? $data[date("M-Y", $period)]['lifetime'] : $data[date("M-Y", $period)]['credit_mtd']);
                $this->excellence =$data[date("M-Y", $period)]['excellence'];
            }
        }

//        $metrics = Json::encode();
//        echo Json::prettyPrint($metrics);
//        dd(11);
        $status = new RetailSalesConsultantStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->newVehicleSales,
                $this->salesRecommendationSaturation,
                $this->followUpSaturation,
                $this->training,
            ],
            'statusChart'=>[
                'jsGage'=>$status->getGageIndicatorJsString(),
                'gageArray'=>$status->getGageIndicators(),
                'color'=>$status->getColor(),
                'colorText'=>$status->getColorText(),
                'toReach'=>$status->getToReach(),
                'min'=>$status->getMin(),
                'max'=>$status->getMax(),
            ]
        ];
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            if(isset($data[date("M-Y", $period)]))
            {
                /**
                 *  Deprecated
                $new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['credit_actual_sales'] . "]";
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['ce_recommendation'] . "]";
                $FU.=(empty($FU) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['follow_up_credit'] . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['pathway'] . "," .  $data[date("M-Y", $period)]['training'] . "," .  $data[date("M-Y", $period)]['classroom'] . "]";

                $sales_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['sales'] . '</td>';
                $recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_recommendation'] . '</td>';
                $fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['follow_up_score'] . '</td>';
                */

                // 新的方式
                $this->JS_newVehicleSales[date("M", $period)] = $data[date("M-Y", $period)]['credit_actual_sales']; // JS OBJECT
                $this->JS_reCommendation[date("M", $period)] = $data[date("M-Y", $period)]['ce_recommendation'];    // JS OBJECT
                $this->JS_followUpCredits[date("M", $period)] = $data[date("M-Y", $period)]['follow_up_credit'];    // JS OBJECT
                $this->JS_training[] = "['".date("M", $period)."',".$data[date("M-Y", $period)]['pathway'].",".$data[date("M-Y", $period)]['training'].",".$data[date("M-Y", $period)]['classroom']."]";


                $this->salesResult[] = $data[date("M-Y", $period)]['sales'];
                $this->salesRecommendationResult[date("M", $period)] = $data[date("M-Y", $period)]['score_recommendation'];
                $this->followUpCredits[] = $data[date("M-Y", $period)]['follow_up_score'];
            }
            else
            {
                /**
                 * Deprecated
                $new.=(empty($new) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $FU.=(empty($FU) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";

                $sales_results.='<td class="' . $class . '">&nbsp;</td>';

                $recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
                $fu_results.='<td class="' . $class . '">&nbsp;</td>';
                 * */

                // 新的方式
                $this->JS_newVehicleSales[date("M", $period)] = 0;
                $this->JS_reCommendation[date("M", $period)]  = 0;
                $this->JS_followUpCredits[date("M", $period)]  = 0;
                $this->JS_training[] = "['".date("M", $period)."',0,0,0]";

                $this->salesResult[] = null;
                $this->salesRecommendationResult[] = null;
                $this->followUpCredits[] = null;
            }

        }

        $this->JS_training = '['.implode(',',$this->JS_training).']';

        return [
            // For js array
            "JS_newVehicleSales"    =>convert_array_to_js_2_dimension_array($this->JS_newVehicleSales),
            "JS_reCommendation"     =>convert_array_to_js_2_dimension_array($this->JS_reCommendation),
            "JS_followUpCredits"    =>convert_array_to_js_2_dimension_array($this->JS_followUpCredits),
            "JS_training"           =>$this->JS_training,
            // For PHP array
            "salesResult"               =>$this->salesResult,
            "salesRecommendationResult" =>$this->salesRecommendationResult,
            "followUpCredits"           =>$this->followUpCredits,
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


}