<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 10:14 AM
 */

namespace App\models\role;

use App\models\role\status\ServiceManagerStatus;
use App\models\User;

class ServiceManager extends BaseRole implements IRole
{
    public $name='service_manager';

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
        $recommendation=$recommendation_results=$clean=$clean_results=$fu=$fu_results=$emw=$emw_results=$training='';
        $class='nissangray-light-back';

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['recommendation_credit'] . "]";
                $clean.=(empty($clean) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['vclean_credit'] . "]";
                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['followup_credit'] . "]";
                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['emw_credit'] . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "," . $data[date("M-Y", $period)]['classroom']  . "]";


                $recommendation_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['recommendation'] . '</td>';
                $clean_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['vclean'] . '</td>';
                $fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['followup'] . '</td>';
                $emw_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['emw'],0) . '</td>';
            }
            else
            {
                $recommendation.=(empty($recommendation) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $clean.=(empty($clean) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0,0]";

                $recommendation_results.='<td class="' . $class . '">&nbsp;</td>';
                $clean_results.='<td class="' . $class . '">&nbsp;</td>';
                $fu_results.='<td class="' . $class . '">&nbsp;</td>';
                $emw_results.='<td class="' . $class . '">&nbsp;</td>';
            }

        }
        return [
            "RECOMMENDATION" => $recommendation,
            "RECOMMENDATION_RESULTS" => $recommendation_results,
            "CLEAN" => $clean,
            "CLEAN_RESULTS" => $clean_results,
            "FOLLOWUP" => $fu,
            "FOLLOWUP_RESULTS" => $fu_results,
            "EMW" => $emw,
            "EMW_RESULTS" => $emw_results,
            "TRAINING" => $training,
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
                $this->serviceRecommendation['data'][] = intval($dataResults[date("M-Y", $period)]['recommendation_credit']);
                $this->VehicleCleanliness['data'][] = intval($dataResults[date("M-Y", $period)]['vclean_credit']);
                $this->followUpPercentage['data'][]  = intval($dataResults[date("M-Y", $period)]['followup_credit']);
                $this->EMW['data'][]  = intval($dataResults[date("M-Y", $period)]['emw_credit']);
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
                $this->serviceRecommendation['data'][] = 0;
                $this->VehicleCleanliness['data'][]  = 0;
                $this->followUpPercentage['data'][]  = 0;
                $this->EMW['data'][]  = 0;
                $this->training['data'][]  = 0;
            }

            $this->_setupLifeTimeAndExcellence($data,$period);
        }

        // Status
        $status = new ServiceManagerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->serviceRecommendation,
                $this->VehicleCleanliness,
                $this->followUpPercentage,
                $this->EMW,
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