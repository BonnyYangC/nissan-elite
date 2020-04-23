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
        'label'=>'GRP',
        'backgroundColor' => IColor::LIGHT_PERU,
        'data'=>[]
    ];
    public $GENUINE_ACCESSORIES = [
        'label'=>'Accessories',
        'backgroundColor' => IColor::SILVER,
        'data'=>[]
    ];
    public $apnur = [
        'label'=>'APNUR',
        'backgroundColor' => IColor::LIGHT_GREEN,
        'data'=>[]
    ];
    public $BRAKE_WIPER = [
        'label'=>'Brake/Wiper',
        'backgroundColor' => IColor::STEEL_BLUE,
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
        $grp=$grp_results=$gas=$gas_results=$training=[];
        for($i=0; $i<12; $i++)
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                $grp[]      = $this->_buildForJs($item['grp_credit']);
                $gas[]      = $this->_buildForJs($item['gas_credit']);
                $apnur[] = $this->_buildForJs([$item['points_apnur_n'],$item['points_apnur_x'],$item['points_apnur_q']]);
                $brake_wiper[]   = $this->_buildForJs($item['brakewpr_credit']);
                $training[] = $this->_buildForJs([$item['training'],$item['pathway'],$item['training_competency'],$item['training_bonus']]);

                $grp_results[] = $this->_buildForTableElement($item['grp']*100,0).'%';
                $gas_results[] = $this->_buildForTableElement($item['gas']*100,0).'%';

                $apnur_n_results[] = $this->_buildForTableElement($item['percent_apnur_n'],0) . '%';
                $apnur_q_results[] = $this->_buildForTableElement($item['percent_apnur_q'],0) . '%';
                $apnur_x_results[] = $this->_buildForTableElement($item['percent_apnur_x'],0) . '%';                
                $brake_wiper_results[]    = '$' . $this->_buildForTableElement($item['brakewpr'],2);

            }
            else
            {
                $grp[]      = $this->_buildForJs(0);
                $gas[]      = $this->_buildForJs(0);
                $apnur[]    = $this->_buildForJs([0,0,0]);                
                $brake_wiper[] = $this->_buildForJs(0);
                $training[] = $this->_buildForJs([0,0,0,0]);

                $grp_results[] = null;
                $gas_results[] = null;

                $apnur_n_results[] = null;
                $apnur_q_results[] = null;
                $apnur_x_results[] = null;
                $brake_wiper_results[] = null;

            }
        }
        return [
            "GRP" => $grp,
            "GRP_RESULTS" => $grp_results,
            "GAS" => $gas,
            "GAS_RESULTS" => $gas_results,
            "APNUR" => $apnur,
            "APNUR_N_RESULTS" => $apnur_n_results,
            "APNUR_Q_RESULTS" => $apnur_q_results,
            "APNUR_X_RESULTS" => $apnur_x_results,
            "TRAINING" => $training,
            "BRAKE_WIPER" => $brake_wiper,
            "BRAKE_WIPER_RESULTS" => $brake_wiper_results,

            
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
                $this->apnur['data'][]              = 
                    intval($item['points_apnur_n']) + 
                    intval($item['points_apnur_q']) + 
                    intval($item['points_apnur_x']);
                $this->BRAKE_WIPER['data'][]  = $item['brakewpr_credit'];                    
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
                $this->apnur['data'][] = 0;
                $this->BRAKE_WIPER['data'][]  = 0;                
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
                $this->apnur,       
                $this->BRAKE_WIPER,
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
