<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 24/7/18
 * Time: 11:42 AM
 */

namespace App\models;


class Lookup extends BaseModel
{
    const GROUP_DEPT = 'DEPT';
    const GROUP_POSITION = 'POSITION';
    protected $tableName = 'lookups';

    /**
     * Get department name by given code and company ID
     * @param $code
     * @param null $companyId
     * @return array|bool
     */
    public function getDepartmentName($code, $companyId = null){
        $where = [
            'AND'=>[
                'code'=>$code,
                'grouping'=>Lookup::GROUP_DEPT,
                'company_id'=>$companyId?$companyId:Company::NISSAN_COMPANY_ID
            ]
        ];
        $rows = $this->simpleQuery($where,['content']);
        $result = null;
        if(count($rows) === 1){
            $result = $rows[0]['content'];
        }
        return $result;
    }

    /**
     * Get position description by given position and company ID
     * @param $position
     * @param null $companyId
     * @return array|bool
     */
    public function getPositionDescription($position,$companyId = null){
        $where = [
            'AND'=>[
                'code'=>$position,
                'grouping'=>Lookup::GROUP_POSITION,
                'company_id'=>$companyId?$companyId:Company::NISSAN_COMPANY_ID
            ]
        ];
        $rows = $this->simpleQuery($where,['content']);

        $result = null;
        if(count($rows) === 1){
            $result = $rows[0]['content'];
        }
        return $result;
    }
}