<?php
/**
 * Created by Justin Wang.
 * This model is not bind with any table, but only for execute the data source queries for Nissan users
 */

namespace App\models\nissan;

use App\models\BaseModel;
use App\models\User;

class DataSource extends BaseModel
{
    /**
     * Map for data source table name and abbr ( User's position shortcut)
     * @var array
     */
    private static $_maps = [
        'nissan_salesconsultants'       => User::RETAIL_SALES_CONSULTANTS,
        'nissan_salesmanagers'          => User::SALES_MANAGER,
        'nissan_serviceadvisors'        => User::SERVICE_ADVISERS,
        'nissan_fi'                     => User::FI,
        'nissan_stockcontroller'        => User::STOCK_CONTROLLER,
        'nissan_financialcontrollers'   => User::FINANCE_CONTROLLER,
        'nissan_partsmanager'           => User::PARTS_MANAGER,
        'nissan_partsrep'               => User::PARTS_SALES_REP,
        'nissan_servicemanagers'        => User::SERVICE_MANAGER
    ];

    /**
     * Tables array of the user has position
     * @var array|null
     */
    private static $_positionList           = null;
    private static $_multipleRoleMetrics    = null;

    /**
     *  A user may have multiple positions, this method returns an array
        of type 'string' with the names of the tables that this employee
        code is present in
     * @param User $user
     * @return array|null
     */
    public static function GetDataAllPositions (User $user) {
        if(is_null(self::$_multipleRoleMetrics)){
            self::$_multipleRoleMetrics = [];
            $tables = self::GetPositionList($user);
            $database = self::DB();
            foreach ($tables as $table) {
                $rows = $database->select(
                    $table,
                    '*',
                    [
                        'member_id'=>$user->getEmployeeCode(),
                        'ORDER'=>'period'
                    ]
                );
                foreach ($rows as $row) {
                    self::$_multipleRoleMetrics[$table]['Results'][date('M-Y', strtotime($row['period']))] = $row;
                    self::$_multipleRoleMetrics[$table]['Excellence'] = $row['excellence'];
                }
            }
        }

        return self::$_multipleRoleMetrics;
    }

    /**
     * @param User $user
     * @return array|null
     */
    public static function GetPositionList(User $user) {
        if(is_null(self::$_positionList)){
            $tables = array_keys(self::$_maps);
            $database = self::DB();
            self::$_positionList = [];
            foreach ($tables as $table) {
                $num_rows = $database->count(
                    $table,
                    '*',
                    ['member_id'=>$user->getEmployeeCode()]
                );
                if ($num_rows > 0) {
                    self::$_positionList[] = $table;
                }
            }
        }
        return self::$_positionList;
    }

    /**
     * Query data source by given user
     * @param User $user
     * @return array|bool
     */
    public static function Query(User $user){
        $currentTableName = self::nissan_get_table_name_from_abbr($user->position);
        $wheres = [
            'member_id'=>$user->getEmployeeCode(),
            'ORDER' => ['period' => 'ASC']
        ];
        switch ($user->position){
            case User::FI:
                break;
            default:
                break;
        }
        $database = self::DB();
        $rows = $database->select(
            $currentTableName,
            '*',
            $wheres
        );

        return [
            'view_name'=>$currentTableName,
            'result'=>self::_handle($rows)
        ];
    }

    /**
     * 处理数据
     * @param $rows
     * @return array
     */
    private static function _handle($rows){
        $result = [];
        foreach ($rows as $row) {
            $result['Results'][date('M-Y', strtotime($row['period']))] = $row;
            $result['Excellence'] = $row['excellence'];
        }
        return $result;
    }


    /**
     * Get abbr from table name
     * @param $table
     * @return string
     */
    public static function nissan_get_abbr_from_table_name ($table) {
        return strtoupper(self::$_maps[$table]);
    }

    /**
     * Get data source table name from abbr
     * @param $abbr
     * @return string
     */
    public static function nissan_get_table_name_from_abbr ($abbr) {
        $result = null;
        $abbr = strtoupper($abbr);
        foreach (self::$_maps as $tableName => $value) {
            if($value == $abbr){
                $result = $tableName;
                break;
            }
        }
        return $result;
    }
}