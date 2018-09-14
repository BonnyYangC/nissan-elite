<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 24/7/18
 * Time: 10:35 AM
 */

namespace App\models;


use App\models\role\IRole;

class Company extends BaseModel implements IRole
{
    const NISSAN_COMPANY_ID = 8;
    const REGION_EASTERN_SHORT = 'E';
    const REGION_EASTERN = 'Eastern';
    const REGION_WESTERN_SHORT = 'W';
    const REGION_WESTERN = 'Western & Central';
    const REGION_NORTHERN_SHORT = 'N';
    const REGION_NORTHERN = 'Northern';
    const REGION_SOUTHERN_SHORT = 'S';
    const REGION_SOUTHERN = 'Southern';
    const TABLE_NAME = 'company';

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

    /**
     * Get region name by give short code
     * @param $regionName
     * @return string
     */
    public static function GetRegionCode($regionName){
        /**
         * Just in case of region name is code, then return itself directly
         */
        if(strlen($regionName) === 1){
            return $regionName;
        }

        $regionCode = self::REGION_WESTERN_SHORT;
        switch ($regionName){
            case self::REGION_EASTERN:
                $regionCode = self::REGION_EASTERN_SHORT;
                break;
            case self::REGION_EASTERN.' Region':
                $regionCode = self::REGION_EASTERN_SHORT;
                break;
            case self::REGION_SOUTHERN:
                $regionCode = self::REGION_SOUTHERN_SHORT;
                break;
            case self::REGION_SOUTHERN.' Region':
                $regionCode = self::REGION_SOUTHERN_SHORT;
                break;
            case self::REGION_NORTHERN:
                $regionCode = self::REGION_NORTHERN_SHORT;
                break;
            case self::REGION_NORTHERN.' Region':
                $regionCode = self::REGION_NORTHERN_SHORT;
                break;
            default:
                break;
        }
        return $regionCode;
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

    /**
     * Get Company data by given company code
     * @param $companyCode
     * @return null
     */
    public static function GetByCompanyCode($companyCode){
        $database = self::DB();

        $result = $database->select(self::TABLE_NAME,'*',[
            'company_code'=>$companyCode
        ]);

        if($result && count($result)>0){
            return $result[0];
        }
        else{
            return null;
        }
    }

    /**
     * @return \App\core\Model|bool
     */
    public function save()
    {
        $this->company_fax = str_replace('-','',$this->company_fax);
        $this->company_name = str_replace('?','\'',$this->company_name);
        $this->region = self::GetRegionCode(trim($this->region));
        return parent::save();
    }

    public static function GetNameList(){
        $database = self::DB();
        $result = $database->select(self::TABLE_NAME,[
            'company_code(c)','company_name(n)'
        ],[
            'AND'=>[
                'parent_id'=>8,
                'company_name[!]'=>'SUSPENSION FILE'
            ]
        ]);
        return $result;
    }

    /**
     * Get the template's name for the role
     * @return string
     */
    public function getTemplateName()
    {
        // TODO: Implement getTemplateName() method.
    }

    public function getMetrics($data)
    {
        // TODO: Implement getMetrics() method.
    }

    public function getDashboardViewData($data, $ytdParam)
    {
        // TODO: Implement getDashboardViewData() method.
    }
}