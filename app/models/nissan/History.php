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
     * @return array|bool
     */
    public static function All(User $user){
        $database = self::DB();

        $rows = $database->select(
            self::TABLE_NAME,
            '*',
            [
                'member_id' =>$user->getEmployeeCode(),
                'ORDER'     =>'period'
            ]
        );
        // Re construct the result for view
        return self::_handle($rows);
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