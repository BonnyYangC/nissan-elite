<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 1:32 PM
 */

namespace App\models\role;

use App\models\User;
class PartsSalesRep
{
    private $user;

    public $name='parts_sales_rep';

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
        $grp=$grp_results=$training='';
        $class='nissangray-light-back';

        for($i=0; $i<12; $i++)
        {
            $period=mktime(0,0,0,4+$i,1,2017);
            $class=($class=='nissangray-light-back' ? 'nissangray-light' : 'nissangray-light-back');
            if(isset($data[date("M-Y", $period)]))
            {
                $grp.=(empty($grp) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['grp_credit'] . "]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "'," . $data[date("M-Y", $period)]['classroom']  . "]";


                $grp_results.='<td class="' . $class . '">' . number_format($data[date("M-Y", $period)]['grp']*100,0) . '%</td>';
            }
            else
            {
                $grp.=(empty($grp) ? '' : ',') . "['" . date("M", $period) . "',0]";
                $training.=(empty($training) ? '' : ',') . "['" . date("M", $period) . "',0]";

                $grp_results.='<td class="' . $class . '">&nbsp;</td>';
            }

        }
        return [
            "GRP" => $grp,
            "GRP_RESULTS" => $grp_results,
            "TRAINING" => $training,
        ];
    }
}