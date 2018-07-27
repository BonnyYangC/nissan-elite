<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/7/18
 * Time: 5:44 PM
 */

namespace App\models\role;


use App\models\User;

class FI
{
    public static $StatusLevelThresholds = [

        'PREMIER'    =>[
            'val'=>50000,
            'color'=>'#B47C37'
        ],
        'AMBASSADOR'    =>[
            'val'=>30000,
            'color'=>'#546E22'
        ],
        'DIPLOMAT'    =>[
            'val'=>25000,
            'color'=>'#BC2628'
        ],
        'CONSUL'    =>[
            'val'=>11000,
            'color'=>'#525357'
        ],
        'DEFAULT'   =>[
            'val'=>0,
            'color'=>'#000000'
        ],
    ];

    /**
     * @var User
     */
    private $user;

    public $name='fi';

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    public function getMetrics(){
        $nfsa=$nfsa_results=$emw=$emw_results=$mmu_results=$ins=$mvi_results=$vpi_results=$pkg_results=$penetration=$penetration_results=$fu=$fu_results='';

        $class='nissangray-light-back';

        foreach (range(0,11) as $i) {
            $period=mktime(0,0,0,4+$i,1,2017);
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $nfsa.=(empty($nfsa) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credit_actual_sales']) ? '0' : $data[date("M-Y", $period)]['credit_actual_sales']) . "]";
                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_emw']) ? '0' : $data[date("M-Y", $period)]['credits_emw']) . "," . (empty($data[date("M-Y", $period)]['credits_mmu']) ? '0' : $data[date("M-Y", $period)]['credits_mmu']) . "]";
                $ins.=(empty($ins) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_mvi']) ? '0' : $data[date("M-Y", $period)]['credits_mvi']) . "," . (empty($data[date("M-Y", $period)]['credits_vpi']) ? '0' : $data[date("M-Y", $period)]['credits_vpi']) . "," . $data[date("M-Y", $period)]['credits_pkg'] . "]";
                $penetration.=(empty($penetration) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_penetration']) ? '0' : $data[date("M-Y", $period)]['credits_penetration']) . "]";
                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "'," . (empty($data[date("M-Y", $period)]['credits_fi']) ? '0' : $data[date("M-Y", $period)]['credits_fi']) . "]";


                $nfsa_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_nfsa'],0) . '</td>';
                $emw_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_emw'],0) . '</td>';
                $mmu_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_mmu'],0) . '</td>';
                $mvi_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_mvi'],0) . '</td>';
                $vpi_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_vpi'],0) . '</td>';
                $pkg_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['sales_pkg'],0) . '</td>';
                $penetration_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['penetration']*100,0) . '%</td>';
                $fu_results.='<td class="' . $class . '">' . $data[date("M-Y", $period)]['score_fi'] . '</td>';
            }
            else
            {
                $nfsa.=(empty($nfsa) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $emw.=(empty($emw) ? '' : ',') . "['" . date("M", $period) . "',0,0]";
                $ins.=(empty($ins) ? '' : ',') . "['" . date("M", $period) . "',0,0,0]";
                $penetration.=(empty($penetration) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $fu.=(empty($fu) ? '' : ',') . "['" . date("M", $period) . "',0]";

                $nfsa_results.='<td class="' . $class . '">&nbsp;</td>';
                $emw_results.='<td class="' . $class . '">&nbsp;</td>';
                $mmu_results.='<td class="' . $class . '">&nbsp;</td>';
                $mvi_results.='<td class="' . $class . '">&nbsp;</td>';
                $vpi_results.='<td class="' . $class . '">&nbsp;</td>';
                $pkg_results.='<td class="' . $class . '">&nbsp;</td>';
                $penetration_results.='<td class="' . $class . '">&nbsp;</td>';
                $fu_results.='<td class="' . $class . '">&nbsp;</td>';
            }
        }
        return [
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
    }
}