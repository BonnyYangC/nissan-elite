<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 14/11/18
 * Time: 9:17 AM
 */

namespace App\models\nissan;
use App\models\BaseModel;

class Faq extends BaseModel
{
    const TABLE_NAME = 'nissan_faq';
    protected $tableName = 'nissan_faq';

    const ACTIVE = true;
    const INACTIVE = false;

    /**
     * Load all incentives for backend
     * @return array|bool
     */
    public static function LoadAll(){
        $database = self::DB();
        $result = $database->select(
            self::TABLE_NAME,
            '*',
            [
                'ORDER'=>['sorting'=>'ASC','question'=>'ASC']
            ]
        );
        return $result;
    }
}