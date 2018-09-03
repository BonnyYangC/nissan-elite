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
        $data = self::GetAll($user, $before2017Only);
        $result = [];

        foreach (range(1992, env('YEAR')) as $yearInteger) {
            $value = 0.0;
            if(isset($data[$yearInteger])){
                $value = $data[$yearInteger]['amount'];
            }
            $result[] = [$yearInteger.'',$value];
        }

        if($before2017Only){
            // 表示只查找2017年以前的记录, 2017年开始的销售总额要从 nissan_credits 表格中提取并单独计算
        }

        return array_reverse($result);
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
                $history[$key]['FF'] = $row;
            }else{
                $history[$key] = $row;
            }
        }
        return $history;
    }
}