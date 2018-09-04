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
        'nissan_salesconsultants'       => [User::RETAIL_SALES_CONSULTANTS,User::FLEET_SALES_MANAGER,User::FLEET_SALES_CONSULTANTS],
        'nissan_salesmanagers'          => User::SALES_MANAGER,
        'nissan_serviceadvisors'        => User::SERVICE_ADVISERS,
        'nissan_fi'                     => User::FI,
        'nissan_stockcontroller'        => User::STOCK_CONTROLLER,
        'nissan_financialcontrollers'   => User::FINANCE_CONTROLLER,
        'nissan_partsmanager'           => User::PARTS_MANAGER,
        'nissan_partsrep'               => User::PARTS_SALES_REP,
        'nissan_servicemanagers'        => User::SERVICE_MANAGER,
        'nissan_region_territory_reports'=> User::DISTRICT_SALES_MANAGER,
    ];

    /**
     * Map for database table's name => user's Role
     * @var array
     */
    public static $_rolesMap = [
        User::RETAIL_SALES_CONSULTANTS      => 'Retail Sales Consultant',
        User::FLEET_SALES_MANAGER           => 'Fleet Sales Manager',
        User::FLEET_SALES_CONSULTANTS       => 'Fleet Sales Consultant',
        User::SALES_MANAGER                 => 'Sales Manager',
        User::SERVICE_ADVISERS              => 'Service Advisor',
        User::FI                            => 'Finance & Insurance Manager',
        User::STOCK_CONTROLLER              => 'Stock Controller',
        User::FINANCE_CONTROLLER            => 'Financial Controller',
        User::PARTS_MANAGER                 => 'Parts Manager',
        User::PARTS_SALES_REP               => 'Parts & Sales Representative',
        User::SERVICE_MANAGER               => 'Service Manager',
        User::DISTRICT_SALES_MANAGER        => 'Region Territory Report',
    ];

    public static $_rolesMapOld = [
        'nissan_salesconsultants'       => 'Sales Consultant',
        'nissan_salesmanagers'          => 'Sales Manager',
        'nissan_serviceadvisors'        => 'Service Advisor',
        'nissan_fi'                     => 'Finance & Insurance Manager',
        'nissan_stockcontroller'        => 'Stock Controller',
        'nissan_financialcontrollers'   => 'Financial Controller',
        'nissan_partsmanager'           => 'Parts Manager',
        'nissan_partsrep'               => 'Parts & Sales Representative',
        'nissan_servicemanagers'        => 'Service Manager'
    ];

    public static $_rolesTableNameMap = [
        User::RETAIL_SALES_CONSULTANTS      => 'nissan_salesconsultants',
        User::FLEET_SALES_MANAGER           => 'nissan_salesconsultants',
        User::FLEET_SALES_CONSULTANTS       => 'nissan_salesconsultants',
        User::SALES_MANAGER                 => 'nissan_salesmanagers',
        User::SERVICE_ADVISERS              => 'nissan_serviceadvisors',
        User::FI                            => 'nissan_fi',
        User::STOCK_CONTROLLER              => 'nissan_stockcontroller',
        User::FINANCE_CONTROLLER            => 'nissan_financialcontrollers',
        User::PARTS_MANAGER                 => 'nissan_partsmanager',
        User::PARTS_SALES_REP               => 'nissan_partsrep',
        User::SERVICE_MANAGER               => 'nissan_servicemanagers',
        User::DISTRICT_SALES_MANAGER        => 'nissan_region_territory_reports',
        Credit::TABLE_NAME                  => Credit::TABLE_NAME ,
    ];

    /**
     * Tables array of the user has position
     * @var array|null
     */
    private static $_positionList           = null;
    private static $_multipleRoleMetrics    = null;
    private static $_tableRoleMetrics       = null;

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
            self::$_tableRoleMetrics = [];
            $tables = self::GetPositionList($user);
            $database = self::DB();
            foreach ($tables as $table) {
                $rows = $database->select(
                    $table,
                    '*',
                    [
                        'member_id'=>$user->getEmployeeCode(),
                        'ORDER'=>[
                            'period'=>'DESC'
                        ]
                    ]
                );

                if(env('DEV_MODE',false)){
                    dump($database->log());
                }

                foreach ($rows as $row) {
                    self::$_multipleRoleMetrics[$table]['Results'][date('M-Y', strtotime($row['period']))] = $row;
                    self::$_multipleRoleMetrics[$table]['Excellence'] = $row['excellence'];
                }
                // Setup the table name and role array to render "Metrics" menu item. 就为了前端菜单渲染一下 Metrics 菜单
                self::$_tableRoleMetrics[$table] = self::$_rolesMap[$table];
            }
        }
        return self::$_multipleRoleMetrics;
    }

    /**
     * Get database table name => role name array by given user
     * @param User $user
     * @return null
     */
    public static function GetTableRoleMetrics(User $user){
        if(is_null(self::$_tableRoleMetrics)){
            self::GetDataAllPositions($user);
        }
        return self::$_tableRoleMetrics;
    }

    /**
     * Get user's positions array; One conditions, for support multiple roles, the user's position has to be set before calling this function
     * 获取用户所有可能的职务的方法. 为了正确获取, 在本方法被调用之前, 必须保证 user 对象的 position 已经被设置, 才能支持多职位的情况
     * @param User $user
     * @return array|null
     */
    public static function GetPositionList(User $user) {
        if(is_null(self::$_positionList)){
            $database = self::DB();
            self::$_positionList = [];
            // Todo : 这里的设计是 - 用户表中的用户角色可能随时发生变化, 因此需要查询所有的表格, 如果有记录条数返回, 表示有对应表角色的数据
            foreach (self::$_maps as $table => $positionAbbr) {
                $num_rows = $database->count(
                    $table,
                    '*',
                    ['member_id'=>$user->getEmployeeCode()]
                );
                if ($num_rows > 0) {
                    $abbr = $positionAbbr;
                    if(is_string($positionAbbr)){
                        $theRoleName = self::getRoleNameByAbbr($positionAbbr);
                    }else{
                        // Position abbr is an array now, so have to use user's current position
                        $theRoleName = self::getRoleNameByAbbr($user->position);
                        $abbr = $user->position;
                    }
                    self::$_positionList[$table] = [
                        'abbr'=>$abbr,
                        'text'=>$theRoleName
                    ];
                }
            }
        }
        return self::$_positionList;
    }

    /**
     * Query data source by given user
     * @param User $user
     * @param string $targetTableName
     * @return array|bool
     */
    public static function Query(User $user, $targetTableName = null){
        $currentTableName = $targetTableName ? $targetTableName : self::nissan_get_table_name_from_abbr($user->position);
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

        if(env('DEV_MODE',false)){
            dump($database->log());
        }

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
     * Get user position abbr from table name
     * 根据给定的数据库表名称获取对应的职务缩写
     * @param $table
     * @return string|array|null
     */
    public static function nissan_get_abbr_from_table_name ($table) {
        if(isset(self::$_maps[$table])){
            return self::$_maps[$table];
        }
        return null;
    }

    /**
     * Get database table name from user position abbr
     * 从用户的职位缩写获取对应的数据库表名称
     * @param $abbr
     * @return string
     */
    public static function nissan_get_table_name_from_abbr ($abbr) {
        return self::$_rolesTableNameMap[$abbr];
    }

    /**
     * Get Role name by given database table name
     * 根据给定的数据库表名称获取职务的文字说明. 因为通过表明会可能得到一个缩写的数组, 因此需要一个 user 对象
     * @param $tableName
     * @param User $user
     * @return string
     */
    public static function getRoleNameByDatabaseTableName($tableName, User $user = null){
        $abbr = self::nissan_get_abbr_from_table_name($tableName);
        if(is_array($abbr)){
            $abbr = $user ? $user->position : null;
        }
        return self::getRoleNameByAbbr($abbr);
    }

    /**
     * Get role name text by abbr
     * 获取职务的文字信息, 根据给定的职务缩写
     * @param $abbr
     * @return mixed
     */
    public static function getRoleNameByAbbr($abbr){
        if(empty($abbr)){
            return null;
        }
        return self::$_rolesMap[$abbr];
    }
}