<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/8/18
 * Time: 2:04 PM
 */

namespace App\models\management;


use App\models\BaseModel;
use App\models\User;

class ManagerRegion extends BaseModel
{
    const TABLE_NAME     = 'nissan_manager_regions';
    protected $tableName = 'nissan_manager_regions';

    protected  $fillable = [
        'company_id',
        'region_name',
        'region_code',
        'user_id',
        'employee_code',
        'created_at'
    ];

    /**
     * Get all regions by given manager
     * @param User $manager
     * @param bool $asArray
     * @return array|bool
     */
    public static function LoadByManager(User $manager, $asArray = true){
        $result = [];
        if(is_null($manager)){
            return $result;
        }
        $database = self::DB();

        $rows = $database->select(
            self::TABLE_NAME,
            '*',
            [
                'user_id'=>$manager->getId()
            ]
        );

        if(!$asArray){
            foreach ($rows as $row) {
                $keys = array_keys($row);
                $mr = new ManagerRegion();
                foreach ($keys as $fieldName) {
                    $mr->$fieldName = $row[$fieldName];
                }
                $result[] = $mr;
            }
        }


        return $asArray ? $rows : $result;
    }
}