<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/7/18
 * Time: 5:44 PM
 */

namespace App\models\role;


use App\models\role\status\FiStatus;
use App\models\role\status\IColor;
use App\models\User;

class FI extends BaseRole implements IRole
{
    const MAX           = 60000;
    const MIN           = 0;
    const PREMIER       = 50000;
    const AMBASSADOR    = 30000;
    const DIPLOMAT      = 25000;
    const CONSUL        = 11000;

    const PREMIER_COLOR       = '#B47C37';
    const AMBASSADOR_COLOR    = '#546E22';
    const DIPLOMAT_COLOR      = '#BC2628';
    const CONSUL_COLOR        = '#525357';
    const DEFAULT_COLOR       = '#000000';

    public $name='fi';

    public $NFSA_Contracts = [
        'label'=>'NFSA CONTRACTS',
        'backgroundColor' => IColor::SILVER,
        'data'=>[]
    ];
    public $Insurance = [
        'label'=>'INSURANCE',
        'backgroundColor' => IColor::STEEL_BLUE,
        'data'=>[]
    ];
    public $EMW_Genuine_Extended = [
        'label'=>'EMW GENUINE',
        'backgroundColor' => IColor::LIGHT_BLUE,
        'data'=>[]
    ];
    public $SalesPenetration = [
        'label'=>'SALES PENETRATION',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public $FollowUp = [
        'label'=>'FI SAT.',
        'backgroundColor' => IColor::LEMON_CHIFFON,
        'data'=>[]
    ];

    public $NFSA_Credits = [
        'label'=>'LOYALTY & RETENTION',
        'backgroundColor' => IColor::SADDLE_BROWN,
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        parent::__construct($user);
        $this->hasPlatinumRanking = false;
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
                $this->JS_credits[date("M", $period)] = empty($item['credit_mtd']) ? 0 : $item['credit_mtd'];
                /**
                 * From Data results
                 */
                $this->NFSA_Contracts['data'][] = intval($item['credit_actual_sales']);
                $this->Insurance['data'][] = intval($item['credits_mvi']) + intval($item['credits_vpi']) + intval($item['credits_pkg']);
                $this->EMW_Genuine_Extended['data'][]  = intval($item['credits_emw']);
                $this->SalesPenetration['data'][]  = intval($item['credits_penetration']);
                $this->FollowUp['data'][]  = intval($item['credits_fi']);
                $this->NFSA_Credits['data'][] = intval($item['credits_nfsa_retention']);
                $this->incentivesForDashboard['data'][] = isset($item['incentive']) && !empty(trim($item['incentive'])) ? intval($item['incentive']) : 0;
            }
            else
            {
                $this->JS_credits[date("M", $period)]  = 0;
                /**
                 * From Data results
                 */
                $this->NFSA_Contracts['data'][] = 0;
                $this->Insurance['data'][]  = 0;
                $this->EMW_Genuine_Extended['data'][]  = 0;
                $this->SalesPenetration['data'][]  = 0;
                $this->FollowUp['data'][]  = 0;
                $this->NFSA_Credits['data'][] = 0;
                $this->incentivesForDashboard['data'][] = 0;
            }

            $this->_setupLifeTimeAndExcellence($dataResults,$period);
        }


//dd($this->EMW_Genuine_Extended);
        // Status
        $status = new FiStatus($ytd);
        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->NFSA_Contracts,
                $this->Insurance,
                $this->EMW_Genuine_Extended,
                $this->SalesPenetration,
                $this->FollowUp,
                $this->NFSA_Credits,
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

    /**
     * @return string
     */
    public function getTemplateName()
    {
        return $this->name;
    }

    /**
     * Fetch data and prepare for metrics
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $nfsa=$nfsa_results=$emw=$emw_results=$mmu_results=$ins=$mvi_results=$vpi_results=$pkg_results=$penetration=$penetration_results=$fu=$fu_results=[];

        $credits_nfsa_retention = [];
        $sales_nfsa_retention = [];

        for($i=0; $i<12; $i++) { 
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                // chart
                $nfsa[] = $this->_buildForJs($item['credit_actual_sales']);
                $credits_nfsa_retention[] = $this->_buildForJs($item['credits_nfsa_retention']);
                $ins[] = $this->_buildForJs(
                    [
                        $item['credits_mvi'],
                        $item['credits_pkg']
                    ]
                );
                $emw[] = $this->_buildForJs(
                    [
                        $item['credits_emw']
                    ]
                );
                $penetration[] = $this->_buildForJs($item['credits_penetration']);
                $fu[] = $this->_buildForJs($item['credits_fi']);


                // table
                $nfsa_results[] = $this->_buildForTableElement($item['sales_nfsa'],0);
                $sales_nfsa_retention[] = $this->_buildForTableElement($item['sales_nfsa_retention'],0);
                $mvi_results[] = $this->_buildForTableElement($item['sales_mvi'],0);
                //$vpi_results[] = $this->_buildForTableElement($item['sales_vpi'],0);
                $pkg_results[] = $this->_buildForTableElement($item['sales_pkg'],0);
                $emw_results[] = $this->_buildForTableElement($item['sales_emw'],0);
                $penetration_results[] = $this->_buildForTableElement( $item['penetration']*100, 1 ) . '%';
                //$mmu_results[] = $this->_buildForTableElement($item['sales_mmu'],0);
                $fu_results[] = $this->_buildForTableElement($item['score_fi'],1);
            }
            else
            {
                $nfsa[] = $this->_buildForJs(0);
                $emw[] = $this->_buildForJs([0]);
                $ins[] = $this->_buildForJs([0,0]);
                $penetration[] = $this->_buildForJs(0);
                $fu[] = $this->_buildForJs(0);
                $credits_nfsa_retention[] = $this->_buildForJs(0);

                $nfsa_results[] = $this->_buildForTableElement();
                $emw_results[] = $this->_buildForTableElement();
                //$mmu_results[] = $this->_buildForTableElement();
                $mvi_results[] = $this->_buildForTableElement();
                //$vpi_results[] = $this->_buildForTableElement();
                $pkg_results[] = $this->_buildForTableElement();
                $penetration_results[] = $this->_buildForTableElement().'%';
                $fu_results[] = $this->_buildForTableElement(null);
                $sales_nfsa_retention[] = $this->_buildForTableElement();
            }
        }

        return  [
            "NFSA"                  => $nfsa,
            "NFSA_RESULTS"          => $nfsa_results,
            // Retention
            "RETENTION_RESULTS"     => $sales_nfsa_retention,
            "RETENTION"             => $credits_nfsa_retention,
            "INSURANCE"             => $ins,
            "INSURANCE_MVI_RESULTS" => $mvi_results,
            //"INSURANCE_VPI_RESULTS" => $vpi_results,
            "INSURANCE_PKG_RESULTS" => $pkg_results,
            "EMW"                   => $emw,
            "EMW_RESULTS"           => $emw_results,
            //"MMU_RESULTS"           => $mmu_results,
            "PENETRATION"           => $penetration,
            "PENETRATION_RESULT"    => $penetration_results,
            "FOLLOW_UP"             => $fu,
            "FOLLOW_UP_RESULTS"     => $fu_results,
        ];
    }
}