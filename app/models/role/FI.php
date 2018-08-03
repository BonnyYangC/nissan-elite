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

    private $dollars = [300,600,1000,1500];

    public $name='fi';

    public $NFSA_Contracts = [
        'label'=>'NFSA Contracts',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $Insurance = [
        'label'=>'Insurance',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $EMW_Genuine_Extended = [
        'label'=>'EMW Genuine/Extended',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];
    public $SalesPenetration = [
        'label'=>'Sales Penetration',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public $FollowUp = [
        'label'=>'Follow Up',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];

    public function __construct(User $user = null)
    {
        parent::__construct($user);
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
                $this->NFSA_Contracts['data'][] = intval($dataResults[date("M-Y", $period)]['credit_actual_sales']);
                $this->Insurance['data'][] = intval($dataResults[date("M-Y", $period)]['credits_mvi']);
                $this->EMW_Genuine_Extended['data'][]  = intval($dataResults[date("M-Y", $period)]['credits_emw']);
                $this->SalesPenetration['data'][]  = intval($dataResults[date("M-Y", $period)]['credits_penetration']);
                $this->FollowUp['data'][]  = intval($dataResults[date("M-Y", $period)]['credits_fi']);
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
            }

            $this->_setupLifeTimeAndExcellence($data,$period);
        }

        // Status
        $status = new FiStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->NFSA_Contracts,
                $this->Insurance,
                $this->EMW_Genuine_Extended,
                $this->SalesPenetration,
                $this->FollowUp,
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

        $class='nissangray-light-back';

        for($i=0; $i<12; $i++) {
            $period=mktime(0,0,0,4+$i,1,env('YEAR'),2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');

            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;

            if($item)
            {
                $nfsa[] = $this->_buildForJs($item['credit_actual_sales']);
                $emw[] = $this->_buildForJs(
                    [
                        $item['credits_emw'],
                        $item['credits_mmu']
                    ]
                );
                $ins[] = $this->_buildForJs(
                    [
                        $item['credits_mvi'],
                        $item['credits_vpi'],
                        $item['credits_pkg']
                    ]
                );
                $penetration[] = $this->_buildForJs($item['credits_penetration']);
                $fu[] = $this->_buildForJs($item['credits_fi']);

//                $nfsa.=(empty($nfsa) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credit_actual_sales']) ? '0' : $data[date("M-Y", $period)]['credit_actual_sales']) . "]";
//                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_emw']) ? '0' : $data[date("M-Y", $period)]['credits_emw']) . "," . (empty($data[date("M-Y", $period)]['credits_mmu']) ? '0' : $data[date("M-Y", $period)]['credits_mmu']) . "]";
//                $ins.=(empty($ins) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_mvi']) ? '0' : $data[date("M-Y", $period)]['credits_mvi']) . "," . (empty($data[date("M-Y", $period)]['credits_vpi']) ? '0' : $data[date("M-Y", $period)]['credits_vpi']) . "," . $data[date("M-Y", $period)]['credits_pkg'] . "]";
//                $penetration.=(empty($penetration) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_penetration']) ? '0' : $data[date("M-Y", $period)]['credits_penetration']) . "]";
//                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_fi']) ? '0' : $data[date("M-Y", $period)]['credits_fi']) . "]";

                $nfsa_results[] = $this->_buildForTableElement($item['sales_nfsa']);
                $emw_results[] = $this->_buildForTableElement($item['sales_emw']);
                $mmu_results[] = $this->_buildForTableElement($item['sales_mmu']);
                $mvi_results[] = $this->_buildForTableElement($item['sales_mvi']);
                $vpi_results[] = $this->_buildForTableElement($item['sales_vpi']);
                $pkg_results[] = $this->_buildForTableElement($item['sales_pkg']);
                $penetration_results[] = $this->_buildForTableElement( $item['penetration']*100, 0 ) . '%';
                $fu_results[] = $this->_buildForTableElement($item['score_fi']);

//                $nfsa_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_nfsa'],0) . '</td>';
//                $emw_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_emw'],0) . '</td>';
//                $mmu_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_mmu'],0) . '</td>';
//                $mvi_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_mvi'],0) . '</td>';
//                $vpi_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_vpi'],0) . '</td>';
//                $pkg_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_pkg'],0) . '</td>';
//                $penetration_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['penetration']*100,0) . '%</td>';
//                $fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_fi'] . '</td>';
            }
            else
            {
                $nfsa[] = $this->_buildForJs(0);
                $emw[] = $this->_buildForJs([0,0]);
                $ins[] = $this->_buildForJs([0,0,0]);
                $penetration[] = $this->_buildForJs(0);
                $fu[] = $this->_buildForJs(0);

//                $nfsa.=(empty($nfsa) ? '' : ',') . "['" . date("M", $period) . "',0]";
//                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
//                $ins.=(empty($ins) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";
//                $penetration.=(empty($penetration) ? '' : ',') . "['" . date("M", $period) . "',0]";
//                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "',0]";

                $nfsa_results[] = $this->_buildForTableElement();
                $emw_results[] = $this->_buildForTableElement();
                $mmu_results[] = $this->_buildForTableElement();
                $mvi_results[] = $this->_buildForTableElement();
                $vpi_results[] = $this->_buildForTableElement();
                $pkg_results[] = $this->_buildForTableElement();
                $penetration_results[] = $this->_buildForTableElement();
                $fu_results[] = $this->_buildForTableElement();

//                $nfsa_results.='<td class="' . $class . '">&nbsp;</td>';
//                $emw_results.='<td class="' . $class . '">&nbsp;</td>';
//                $mmu_results.='<td class="' . $class . '">&nbsp;</td>';
//                $mvi_results.='<td class="' . $class . '">&nbsp;</td>';
//                $vpi_results.='<td class="' . $class . '">&nbsp;</td>';
//                $pkg_results.='<td class="' . $class . '">&nbsp;</td>';
//                $penetration_results.='<td class="' . $class . '">&nbsp;</td>';
//                $fu_results.='<td class="' . $class . '">&nbsp;</td>';
            }
        }
        $metrics =  [
            "NFSA" => $nfsa,
            "NFSA_RESULTS" => $nfsa_results,
            "EMW" => $emw,
            "EMW_RESULTS" => $emw_results,
            "MMU_RESULTS" => $mmu_results,
            "INSURANCE" => $ins,
            "INSURANCE_MVI_RESULTS" => $mvi_results,
            "INSURANCE_VPI_RESULTS" => $vpi_results,
            "INSURANCE_PKG_RESULTS" => $pkg_results,
            "PENETRATION" => $penetration,
            "PENETRATION_RESULT" => $penetration_results,
            "FOLLOW_UP" => $fu,
            "FOLLOW_UP_RESULTS" => $fu_results
        ];
        return $metrics;
    }
}