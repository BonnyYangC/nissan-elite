<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 24/7/18
 * Time: 10:35 AM
 */

namespace App\models;


class Company extends BaseModel
{
    const NISSAN_COMPANY_ID = 8;
    const REGION_EASTERN_SHORT = 'E';
    const REGION_EASTERN = 'Eastern';
    const REGION_WESTERN_SHORT = 'W';
    const REGION_WESTERN = 'Western';
    const REGION_NORTHERN_SHORT = 'N';
    const REGION_NORTHERN = 'Northern';
    const REGION_SOUTHERN_SHORT = 'E';
    const REGION_SOUTHERN = 'Southern';

    protected $tableName = 'company';
    protected $idFieldName = 'company_id';

    /**
     * Get region name by give short code
     * @param $regionCode
     * @return string
     */
    public static function GetRegionName($regionCode){
        $region = self::REGION_SOUTHERN;
        switch ($regionCode){
            case self::REGION_EASTERN_SHORT:
                $region = self::REGION_EASTERN;
                break;
            case self::REGION_WESTERN_SHORT:
                $region = self::REGION_WESTERN;
                break;
            case self::REGION_NORTHERN_SHORT:
                $region = self::REGION_NORTHERN;
                break;
            default:
                break;
        }
        return $region;
    }

    public function load(User $user, Lookup $lookup){

        $joins = [
            '[>]'.$lookup->getTableName().'(d)' => [
                'd.code'=>$user->dept,
                'd.grouping'=>'DEPT',
                'd.company_id'=>Company::NISSAN_COMPANY_ID
            ],
            '[>]'.$lookup->getTableName().'(p)' => [
                'p.code'=>$user->position,
                'p.grouping'=>'POSITION',
                'p.company_id'=>Company::NISSAN_COMPANY_ID
            ],
        ];
        $columns = [
            'company.company_name',
            'company.company_code',
            'company.category',
            'company.region',
            'd.content as department_name',
            'p.content as position_desc',
        ];
        $where = [
            'OR'=>[
                'company.parent_id'=>Company::NISSAN_COMPANY_ID,
                'company.company_id'=>Company::NISSAN_COMPANY_ID
            ]
        ];

        $database = self::DB();
        $result = $database->select(
            $this->tableName.'('.$this->tableName.')',
            $joins,$columns,$where
        );

        return $result;
    }
}