<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 12:08 PM
 */

namespace App\models\role;

use App\models\role\status\PartsManagerStatus;
use App\models\User;
use App\models\role\status\IColor;
class PartsManager extends BaseRole implements IRole
{
    public $name='parts_manager';

    public $GENUINE_REPLACEMENT_PARTS = [
        'label'=>'GENUINE REPLACEMENT PARTS',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $GENUINE_ACCESSORIES = [
        'label'=>'GENUINE ACCESSORIES',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];

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
        $grp=$grp_results=$gas=$gas_results=$training=[];
        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                $grp[]      = $this->_buildForJs($item['grp_credit']);
                $gas[]      = $this->_buildForJs($item['gas_credit']);
                $training[] = $this->_buildForJs([$item['training'],$item['pathway'],$item['training_competency']]);

                $grp_results[] = $this->_buildForTableElement($item['grp']*100,0).'%';
                $gas_results[] = $this->_buildForTableElement($item['gas']*100,0).'%';
            }
            else
            {
                $grp[]      = $this->_buildForJs(0);
                $gas[]      = $this->_buildForJs(0);
                $training[] = $this->_buildForJs([0,0,0]);

                $grp_results[] = null;
                $gas_results[] = null;
            }
        }
        return [
            "GRP" => $grp,
            "GRP_RESULTS" => $grp_results,
            "GAS" => $gas,
            "GAS_RESULTS" => $gas_results,
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
                $ytd    = $item['credit_ytd'];
                $this->JS_credits[date("M", $period)] = $item['credit_mtd'];
                /**
                 * From Data results
                 */
                $this->GENUINE_REPLACEMENT_PARTS['data'][] = intval($item['grp_credit']);
                $this->GENUINE_ACCESSORIES['data'][] = intval($item['gas_credit']);
                $this->trainingData['data'][]  = $item['training']
                    + $item['pathway']
                    + $item['training_competency'];
                $this->incentivesForDashboard['data'][] = isset($item['incentive']) && !empty(trim($item['incentive'])) ? intval($item['incentive']) : 0;
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;
                /**
                 * From Data results
                 */
                $this->GENUINE_REPLACEMENT_PARTS['data'][] = 0;
                $this->GENUINE_ACCESSORIES['data'][]  = 0;
                $this->trainingData['data'][]  = 0;
                $this->incentivesForDashboard['data'][] = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
        }

        // Status
        $status = new PartsManagerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->GENUINE_REPLACEMENT_PARTS,
                $this->GENUINE_ACCESSORIES,
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