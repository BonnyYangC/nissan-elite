<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 1:12 PM
 */

namespace App\models\role;

use App\models\User;
class StockController
{
    private $user;

    public $name='stock_controller';

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        $stock=$stock_results=$ow=$ow_results=$retail=$retail_results=$matched=$matched_results=$davo=$davo_results=$training='';

        $class='nissangray-light-back';

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $stock.=(empty($stock) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['stock_credit'] . "]";
                $ow.=(empty($ow) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['ow_credit'] . "]";
                $retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['retail_credit'] . "]";
                $matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['matched_credit'] . "]";
                $davo.=(empty($davo) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['davo_credit'] . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['training'] . "]";


                $stock_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['stock'],0) . '</td>';
                $ow_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['ow'],0) . '</td>';
                $retail_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['retail']*100,0) . '%</td>';
                $matched_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['matched'],0) . '</td>';
                $davo_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['davo']*100,0) . '%</td>';
            }
            else
            {
                $stock.=(empty($stock) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $ow.=(empty($ow) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $retail.=(empty($retail) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $matched.=(empty($matched) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $davo.=(empty($davo) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0]";

                $stock_results.='<td class="' . $class . '">&nbsp;</td>';
                $ow_results.='<td class="' . $class . '">&nbsp;</td>';
                $retail_results.='<td class="' . $class . '">&nbsp;</td>';
                $matched_results.='<td class="' . $class . '">&nbsp;</td>';
                $davo_results.='<td class="' . $class . '">&nbsp;</td>';
            }

        }
        return [
            "STOCK_COVER" => $stock,
            "STOCK_COVER_RESULTS" => $stock_results,
            "OW" => $ow,
            "OW_RESULTS" => $ow_results,
            "RETAIL" => $retail,
            "RETAIL_RESULTS" => $retail_results,
            "MATCHED" => $matched,
            "MATCHED_RESULTS" => $matched_results,
            "DAVO" => $davo,
            "DAVO_RESULTS" => $davo_results,
            "TRAINING" => $training
        ];
    }
}