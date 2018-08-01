<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 1:12 PM
 */

namespace App\models\role;

use App\models\role\status\IColor;
use App\models\role\status\StockControllerStatus;
use App\models\User;
class StockController extends BaseRole implements IRole
{
    public $name='stock_controller';

    /**
     * View's data
     */
    public $StockCover = [
        'label'=>'Stock Cover',
        'backgroundColor' => IColor::BLACK,
        'data'=>[]
    ];
    public $OWDataEntry = [
        'label'=>'OW Data Entry',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $RetailMidMth = [
        'label'=>'Retail % Mid Mth',
        'backgroundColor' => IColor::MID_GREY,
        'data'=>[]
    ];
    public $OWCompliance = [
        'label'=>'OW Compliance',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public $Davo = [
        'label'=>'Davo',
        'backgroundColor' => IColor::LIGHT_GREY,
        'data'=>[]
    ];
    /* Views data */

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
                $this->StockCover['data'][] = intval($dataResults[date("M-Y", $period)]['stock_credit']);
                $this->OWDataEntry['data'][] = intval($dataResults[date("M-Y", $period)]['ow_credit']);
                $this->RetailMidMth['data'][]  = intval($dataResults[date("M-Y", $period)]['retail_credit']);
                $this->OWCompliance['data'][]  = intval($dataResults[date("M-Y", $period)]['matched_credit']);
                $this->Davo['data'][]  = intval($dataResults[date("M-Y", $period)]['davo_credit']);
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
                $this->StockCover['data'][] = 0;
                $this->OWDataEntry['data'][]  = 0;
                $this->RetailMidMth['data'][]  = 0;
                $this->OWCompliance['data'][]  = 0;
                $this->Davo['data'][]  = 0;
                $this->training['data'][]  = 0;
            }

            // User parent method to handle lifeTime and excellence
            $this->_setupLifeTimeAndExcellence($data, $period);
        }

        // Status
        $status = new StockControllerStatus($ytd);

        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellence,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->StockCover,
                $this->OWDataEntry,
                $this->RetailMidMth,
                $this->OWCompliance,
                $this->Davo,
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