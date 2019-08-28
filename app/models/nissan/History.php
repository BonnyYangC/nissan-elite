<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/7/18
 * Time: 10:39 AM
 */

namespace App\models\nissan;


use App\models\BaseModel;
use App\models\User;

class History extends BaseModel
{
    const TABLE_NAME = 'nissan_history';
    protected $tableName = 'nissan_history';

    /**
     * @param User $user
     * @param bool $before2017Only
     * @return array|bool
     */
    public static function GetAll(User $user, $before2017Only = false){
        $database = self::DB();

        if($before2017Only){
            $where = [
                'AND'=>[
                    'member_id' =>$user->getEmployeeCode(),
                    'period[<]' =>'2017-00-00',
                ]
            ];
        }else{
            $where = [
                'member_id' =>$user->getEmployeeCode(),
            ];
        }

        $where['ORDER'] = 'period';
        $rows = $database->select(
            self::TABLE_NAME,
            '*',
            $where
        );
        // Re construct the result for view
        return self::_handle($rows);
    }

    /**
     * Get lifetime history
     * @param User $user
     * @param bool $before2017Only
     * @return array
     */
    public static function GetLifetime(User $user, $before2017Only = false){
//        $data = self::GetAll($user, $before2017Only);
//        $r2017 = Credit::QueryByUserAndYearPeriod($user,2017);
//        $credits2017 = 0;
//        foreach ($r2017 as $item) {
//            $credits2017 += floatval($item['mtd']);
//        }
//        $result = [];
//
//        foreach (range(1992, configuration('YEAR')) as $yearInteger) {
//            $value = 0;
//            $hasFF = false;
//            $ffValue = 0;
//            $normalValue = 0;
//            if(isset($data[$yearInteger])){
//                if($yearInteger === 2017){
//                    $value = $credits2017;
//                }else{
//                    $value = floatval($data[$yearInteger]['amount']);
//                    if(isset($data[$yearInteger]['FF'])){
//                        $hasFF = true;
//                        $ffValue = floatval($data[$yearInteger]['FF']['amount']);
//                        $normalValue = $value;
//                        $value = $value + $ffValue;
//                    }
//                }
//            }
//            $result[] = [
//                $yearInteger.'',
//                floatval($value),
//                $hasFF ? $normalValue : $value,
//                $hasFF ? $ffValue : 0
//            ];
//        }
//
//        if($before2017Only){
//            // 表示只查找2017年以前的记录, 2017年开始的销售总额要从 nissan_credits 表格中提取并单独计算
//        }


//        dd($result);
//        dd($r2017);

        $rows = self::DB()->select(self::TABLE_NAME,'*',[
            'member_id'=>$user->getEmployeeCode(),
            'ORDER'=>[
                'period'=>'DESC'
            ]
        ]);

        $buffer = [];
        $result = [];
        foreach ($rows as $row) {
            $year = substr($row['period'],0,4);
            if(isset($buffer[$year])){
                $buffer[$year][1] = floatval($row['amount']);
            }else{
                $buffer[$year][0] = floatval($row['amount']);
            }
        }

        foreach ($buffer as $year=>$values) {
            $subTotal = $values[0];
            $result[] = [
                $year.'',
                $subTotal,
                isset($values[1]) ? $subTotal+$values[1] : $subTotal,
                isset($values[1]) ? $values[1] : 0
            ];
        }

//        dd($result);

        return $result;
    }

    /**
     * Get someone's history by member id and period
     * @param $period
     * @param $memberId
     * @return History
     */
    public static function GetByPeriodAndMemberId($period, $memberId){
        $database = self::DB();
        $result = $database->select(self::TABLE_NAME,'*',[
            'AND'=>[
                'period'=>$period,
                'member_id'=>$memberId,
            ]
        ]);
        $history = new History();
        $history->period = $period;
        $history->member_id = $memberId;

        if($result){
            $row = $result[0];
            $history->id = $row['id'];
            $history->amount = $row['amount'];
        }
        return $history;
    }

    /**
     * 在原来 db.php -> line 370
     * @param $rows
     * @return array
     */
    private static function _handle($rows){
        $history = [];
        foreach ($rows as $row) {
            $key = date("Y", strtotime($row['period']) );
            if(isset($history[$key])){
                $history[$key]['FF'] = $row; // Fast Finish data for 2015 only
            }else{
                $history[$key] = $row;
            }
        }
//        dd($history);
        return $history;
    }
}