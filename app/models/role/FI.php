<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/7/18
 * Time: 5:44 PM
 */

namespace App\models\role;


use App\models\User;

class FI implements IRole
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

    /**
     * @var User
     */
    private $user;

    public $name='fi';

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    public function getDashboardViewData($data, $ytd)
    {
        // TODO: Implement getDashboardViewData() method.
        $nfsa=$ins=$emw=$penetration=$fu='';

        $dollar='<tr class="active">';
        foreach ($this->dollars as $item) {
            $dollar .= '<td align="center">$'.$item.'</td>';
        }
        $dollar .= '</tr>';

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,env('YEAR',2017));
            if(isset($data[date("M-Y", $period)]))
            {
                $nfsa.=(empty($nfsa)
                        ? '{ label: \'NFSA Contracts\', backgroundColor: window.chartColors.black, data:['
                        : ',') . $data[date("M-Y", $period)]['credit_actual_sales'];
                $ins.=(empty($ins)
                        ? '{ label: \'Insurance\', backgroundColor: window.chartColors.darkgrey, data:['
                        : ',') . ($data[date("M-Y", $period)]['credits_mvi'] + $data[date("M-Y", $period)]['credits_vpi'] + $data[date("M-Y", $period)]['credits_pkg']);
                $emw.=(empty($emw)
                        ? '{ label: \'EMW Genuine/Extended\', backgroundColor: window.chartColors.midgrey, data:['
                        : ',') . $data[date("M-Y", $period)]['credits_emw'];
                $penetration.=(empty($penetration)
                        ? '{ label: \'Sales Penetration\', backgroundColor: window.chartColors.lowred, data:['
                        : ',') . $data[date("M-Y", $period)]['credits_penetration'];
                $fu.=(empty($fu)
                        ? '{ label: \'Follow Up\', backgroundColor: window.chartColors.lightgrey, data:['
                        : ',') . $data[date("M-Y", $period)]['credits_fi'];
            }
            else
            {
                $nfsa.=(empty($nfsa)
                        ? '{ label: \'NFSA Contracts\', backgroundColor: window.chartColors.black, data:['
                        : ',') . '0';
                $ins.=(empty($ins)
                        ? '{ label: \'Insurance\', backgroundColor: window.chartColors.darkgrey, data:['
                        : ',') . '0';
                $emw.=(empty($emw)
                        ? '{ label: \'EMW Genuine/Extended\', backgroundColor: window.chartColors.midgrey, data:['
                        : ',') . '0';
                $penetration.=(empty($penetration)
                        ? '{ label: \'Sales Penetration\', backgroundColor: window.chartColors.lowred, data:['
                        : ',') . '0';
                $fu.=(empty($fu)
                        ? '{ label: \'Follow Up\', backgroundColor: window.chartColors.lightgrey, data:['
                        : ',') . '0';
            }
        }

        $nfsa.=']}';
        $ins.=']}';
        $emw.=']}';
        $penetration.=']}';
        $fu.=']}';
        $metrics=$nfsa . ',' . $ins . ',' . $emw . ',' . $penetration . ',' . $fu;

        /* Status Level Thresholds */
        $gage_indicators = "";
        $gage_indicators .= "generateGageIndicator('g1', " . (self::CONSUL / self::MAX) * 100 . ", '".self::CONSUL_COLOR."', '".IRole::CONSUL_STR ."');";
        $gage_indicators .= "generateGageIndicator('g1', " . (self::DIPLOMAT / self::MAX) * 100 . ", '".self::DIPLOMAT_COLOR."', '".IRole::DIPLOMAT_STR ."');";
        $gage_indicators .= "generateGageIndicator('g1', " . (self::AMBASSADOR / self::MAX) * 100 . ", '".self::AMBASSADOR_COLOR."', '".IRole::AMBASSADOR_STR ."');";
        $gage_indicators .= "generateGageIndicator('g1', " . (self::PREMIER / self::MAX) * 100 . ", '".self::PREMIER_COLOR."', '".IRole::PREMIER_STR ."');";

        if ( $ytd>= self::PREMIER) {
            //	Premier
            $color=self::PREMIER_COLOR;
            $txt='';
        } elseif ($ytd>=self::AMBASSADOR) {
            //	Ambassador
            // $min=6000;
            $color=self::PREMIER_COLOR;
            $txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format(self::PREMIER - $ytd,0) . '</span> credits to reach Premier level';
        } elseif ($ytd >=self::DIPLOMAT) {
            //	Diplomat
            // $min=11000;
            $color=self::DIPLOMAT_COLOR;
            $txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format(self::AMBASSADOR-$ytd,0) . '</span> credits to reach Ambassador level';
        } elseif ($ytd >= self::CONSUL) {
            //	Consul
            $color=self::CONSUL_COLOR;
            $txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format(self::DIPLOMAT-$ytd,0) . '</span> credits to reach Diplomat level';
        } else {
            //$min=$ytd;
            $color='#000';
            $txt = '<span style="color:#ff0000;margin-top:20px;">' . number_format(self::CONSUL - $ytd,0) . '</span> credits to reach Consul level';
        }

        return [
            'color'             =>$color,
            'txt'               =>$txt,
            'gage_indicators'   =>$gage_indicators,
            'metrics'           =>$metrics,
            'dollar'            =>$dollar,
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

        $nfsa=$nfsa_results=$emw=$emw_results=$mmu_results=$ins=$mvi_results=$vpi_results=$pkg_results=$penetration=$penetration_results=$fu=$fu_results='';

        $class='nissangray-light-back';

        for($i=0; $i<12; $i++) {
            $period=mktime(0,0,0,4+$i,1,env('YEAR'),2017);
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