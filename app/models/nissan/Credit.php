<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/7/18
 * Time: 11:00 AM
 */

namespace App\models\nissan;
use App\models\BaseModel;
use App\models\User;

class Credit extends BaseModel
{
    const TABLE_NAME = 'nissan_credits';
    protected $tableName = 'nissan_credits';

    /**
     *
     * @param User $user
     * @param $year
     * @return array
     */
    public static function QueryByUserAndYearPeriod(User $user, $year){
        $database = self::DB();
        $year = intval($year);
        $from = $year.'-04-01';
        $to = ($year+1).'-03-31';

        $rows = $database->select(
            self::TABLE_NAME,
            '*',
            [
                'AND'=>[
                    'member_id'=>$user->getEmployeeCode(),
                    'period[<>]'=>[
                        $from, $to
                    ]
                ]
            ]
        );
        return self::_handle($rows);
    }

    /**
     * Re construct the database query result rows for view
     * @param $rows
     * @return array
     */
    public static function _handle($rows){
        $credits = [];
        foreach ($rows as $row) {
            $credits[date("M-Y", strtotime($row['period']))] = $row;
        }
        return $credits;
    }
}