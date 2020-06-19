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
        'backgroundColor' => IColor::RED,
        'data'=>[]
    ];
    public $OWDataEntry = [
        'label'=>'OW Data',
        'backgroundColor' => IColor::LIGHT_GREY,
        'data'=>[]
    ];
    public $RetailMidMth = [
        'label'=> 'Retail Forecast',
        'backgroundColor' => IColor::LIGHT_BLUE,
        'data'=>[]
    ];
    public $OWCompliance = [
        'label'=>'Matched OW',
        'backgroundColor' => IColor::LOW_RED,
        'data'=>[]
    ];
    public $Davo = [
        'label'=>'DAVO',
        'backgroundColor' => IColor::DARK_GREY,
        'data'=>[]
    ];
    public $RegVRet = [
        'label'=>'Reg VS. Retail',
        'backgroundColor' => IColor::STEEL_BLUE,
        'data'=>[]
    ];
    /* Views data */

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
        $stock=$stock_results=$ow=$ow_results=$retail=$retail_results=$matched=$matched_results=$davo=$davo_results=$regvret=$regvret_results=$training=[];

        for($i=0; $i<12; $i++) 
        {
            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($data[$key]) ? $data[$key] : null;
            if($item)
            {
                //1
                $stock[] = $this->_buildForJs($item['stock_credit']);
                $stock_results[] = $this->_buildForTableElement($item['stock'],0);
                //2
                $ow[] = $this->_buildForJs($item['ow_credit']);
                $ow_results[] = $this->_buildForTableElement($item['ow'],0);
                //3
                $retail[] = $this->_buildForJs($item['retail_credit']);
                $retail_results[] = $item['retail'] == 2 ? 
                    'NA' : 
                    (
                        $item['retail'] > 0 ? 
                            'YES' : 
                            'NO'
                    );

                //4
                $matched[] = $this->_buildForJs($item['matched_credit']);
                $matched_results[] = $this->_buildForTableElement($item['matched'],0);
                //5
                $davo[] = $this->_buildForJs($item['davo_credit']);
                $davo_results[] = $this->_buildForTableElement($item['davo']*100,0).'%';
                //6
                $regvret[] = $this->_buildForJs($item['points_regvret']);
                $regvret_results[] = $this->_buildForTableElement($item['percentage_regvret']*100,0).'%';
                //7
                $training[] = $this->_buildForJs([$item['training'],$item['pathway'],$item['training_competency']]);

            }
            else
            {
                $stock[] = $this->_buildForJs(0);
                $ow[] = $this->_buildForJs($item['ow_credit']);
                $retail[] = $this->_buildForJs(0);
                $matched[] = $this->_buildForJs(0);
                $davo[] = $this->_buildForJs(0);
                $regvret[] = $this->_buildForJs(0);
                $training[] = $this->_buildForJs([0,0,0]);

                $stock_results[] = null;
                $ow_results[] = null;
                $retail_results[] = null;
                $matched_results[] = null;
                $davo_results[] = null;
                $regvret_results[] = null;
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
            "REGVRET" => $regvret,
            "REGVRET_RESULTS" => $regvret_results,
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

            $key = $this->startPoint->addMonth()->format('M-Y');
            $item = isset($dataResults[$key]) ? $dataResults[$key] : null;

            if($item)
            {
                $ytd=$item['credit_ytd'];
                $this->JS_credits[date("M", $period)] = $item['credit_mtd'] ? $item['credit_mtd'] : 0;
                /**
                 * From Data results
                 */
                $this->StockCover['data'][] = intval($item['stock_credit']);
                $this->OWDataEntry['data'][] = intval($item['ow_credit']);
                $this->RetailMidMth['data'][]  = intval($item['retail_credit']);
                $this->OWCompliance['data'][]  = intval($item['matched_credit']);
                $this->RegVRet['data'][]  = intval($item['points_regvret']);
                $this->Davo['data'][]  = intval($item['davo_credit']);
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
                $this->StockCover['data'][] = 0;
                $this->OWDataEntry['data'][]  = 0;
                $this->RetailMidMth['data'][]  = 0;
                $this->OWCompliance['data'][]  = 0;
                $this->Davo['data'][]  = 0;
                $this->RegVRet['data'][] = 0;
                $this->trainingData['data'][]  = 0;
                $this->incentivesForDashboard['data'][]  = 0;
            }

            // User parent method to handle lifeTime and excellence
            $this->_setupLifeTimeAndExcellence($dataResults, $period);
        }

        // Status
        $status = new StockControllerStatus($ytd);

        //$this->RetailMidMth['label'] = configuration('YEAR') == 2017 ? 'Retail % Mid Mth' : 'Retail Forecast';
        switch (configuration('YEAR')) {
            case 2017:
                $this->RetailMidMth['label'] = 'Retail % Mid Mth';
                break;
            case 2020:
                break;
            default:
                $this->RetailMidMth['label'] = 'Retail Forecast';
                break;
        }
        
        return [
            // For js array
            "JS_credits"    =>convert_array_to_js_2_dimension_array($this->JS_credits),
            // For PHP array
            "lifeTime"      =>$this->lifeTime,
            "excellence"    =>$this->excellenceResult,
            "ytd"           =>$ytd,
            'rewardsDollars'=>$this->user->getDollarRewardsRange(),
            'metricsCurrentStatus'   =>[
                $this->StockCover,
                $this->OWDataEntry,
                $this->RetailMidMth,
                $this->OWCompliance,
                $this->Davo,
                $this->RegVRet,
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