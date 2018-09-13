<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 20/7/18
 * Time: 1:24 PM
 */

namespace App\models;

use App\core\contracts\support\Mailable;
use App\models\management\ManagerDealer;
use App\models\management\ManagerRegion;
use App\models\nissan\DataSource;
use App\core\contracts\support\MailTrait;
use App\models\nissan\Ranking;
use App\models\role\IRole;

class User extends BaseModel implements Mailable, IRole
{
    use MailTrait;

    // Nissan user's position define
    const RETAIL_SALES_CONSULTANTS  = 'R';
    const FLEET_SALES_CONSULTANTS   = 'F';
    const FLEET_SALES_MANAGER       = 'FM';
    const SALES_MANAGER             = 'M';
    const SERVICE_ADVISERS          = 'SA';
    const STOCK_CONTROLLER          = 'SC';
    const FINANCE_CONTROLLER        = 'C';
    const PARTS_MANAGER             = 'PM';
    const PARTS_SALES_REP           = 'PS';
    const SERVICE_MANAGER           = 'SM';
    const FI                        = 'I';

    // The following roles don't need a dashboard
    const REGION_STAFF    = 'region_staff';
    const DISTRICT_SALES_MANAGER    = 'DSM';
    const DISTRICT_SALES_MANAGER_FULL    = 'Region Staff';

    const NATIONAL_SALES_MANAGER    = 'GSM';
    const NATIONAL_SALES_MANAGER_FULL    = 'General Sales Manager';
    const RSM = 'RSM';
    const FOM = 'FOM';
    const ROM = 'ROM';
    const FDM = 'FDM';
    const RAM = 'RAM';
    const DTS = 'DTS';
    const ROA = 'ROA';
    const RSC = 'RSC';
    const RSM_NFSA = 'RSM NFSA';
    const DAM_NFSA = 'DAM NFSA';
    const RM_NFSA = 'RM NFSA';
    const RGM = 'RGM';
    const ADMIN = 'ADMIN';
    const NISSAN_SUPER = 'NISSAN_SUPER';

    const SHOP_OWNER = 'SHOP_OWNER';

    const TABLE_NAME = 'users';

    /**
     * User's database table name
     * @var string
     */
    protected $tableName = 'users';

    /**
     * User's primary key field name
     * @var string
     */
    protected $idFieldName = 'user_id';

    /**
     * @var Company
     */
    private $company = null;

    /**
     * User's positions
     * @var null | array
     */
    private $positions = null;

    /**
     * Regions which managed by Current user
     * @var null|array
     */
    public $managedRegions = null;

    /**
     * Shops/Dealers owned by current user
     * @var null | array
     */
    private $ownedDealers     = null;

    public function __construct($id = null)
    {
        parent::__construct($id);
        if($id){
            $this->init();
        }
    }

    /**
     * @param $firstName
     * @param $lastName
     * @return array|bool
     */
    public static function SearchByFirstNameAndLastName($firstName, $lastName){
        $db = self::DB();
        $result = $db->select('users','*',[
            'AND'=>[
                'firstname'=>$firstName,
                'lastname'=>$lastName,
                'active'=>1,
            ]
        ]);
        return $result;
    }

    /**
     * Get nissan super users
     * @return array|bool
     */
    public static function GetNissanSuperUsers(){
        $where = [
            'users.parent_id'=>8,
            'users.company_id'=>8,
            'users.position'=>self::NISSAN_SUPER,
        ];

        $db = self::DB();
        $result = $db->select('users','*',[
            'AND'=>$where
        ]);

        return $result;
    }

    /**
     * Get region staff
     * @param array $options
     * @param int $pageNumber
     * @param int $limit
     * @return array|bool
     */
    public static function GetRegionStaff($options=[],$pageNumber = 0, $limit = 20){
        if(count($options)>0){
            $where = [
                'users.parent_id'=>8,
                'users.company_id'=>8
            ];
            foreach ($options as $fieldName=>$value){
                $where[$fieldName] = $value;
            }
        }else{
            $where = [
                'users.parent_id'=>8,
                'users.company_id'=>8
            ];
        }

        $db = self::DB();
        $result = $db->select('users','*',[
            'AND'=>$where
        ]);

        return $result;
    }

    /**
     * Search and get user brief data + company brief data
     * @param array $options
     * @param int $pageNumber
     * @param int $limit
     * @return array|bool
     */
    public static function Listing($options=[],$pageNumber = 0, $limit = 20){
        if(is_null($limit)){
            $limit = env('PAGE_SIZE');
        }

        if(count($options)>0){
            $where = [
                'users.active'=>1,
                'company.parent_id'=>8,
                'users.position'=>[
                    self::RETAIL_SALES_CONSULTANTS,
                    self::FLEET_SALES_CONSULTANTS,
                    self::FLEET_SALES_MANAGER,
                    self::SALES_MANAGER,
                    self::SERVICE_ADVISERS,
                    self::STOCK_CONTROLLER,
                    self::FINANCE_CONTROLLER,
                    self::PARTS_MANAGER,
                    self::PARTS_SALES_REP,
                    self::SERVICE_MANAGER,
                    self::FI,
                ]
            ];
            foreach ($options as $fieldName=>$value){
                $where[$fieldName] = $value;
            }
        }else{
            $where = [
                'users.active'=>1,
                'company.parent_id'=>8,
                'users.position'=>[
                    self::RETAIL_SALES_CONSULTANTS,
                    self::FLEET_SALES_CONSULTANTS,
                    self::FLEET_SALES_MANAGER,
                    self::SALES_MANAGER,
                    self::SERVICE_ADVISERS,
                    self::STOCK_CONTROLLER,
                    self::FINANCE_CONTROLLER,
                    self::PARTS_MANAGER,
                    self::PARTS_SALES_REP,
                    self::SERVICE_MANAGER,
                    self::FI,
                ]
            ];
        }

        $db = self::DB();
        $result = $db->select('users',[
            // The row company_id from table users is equal the row company_id from table company
            "[>]company" => ["company_id" => "company_id"],
        ],[
            'users.user_id','users.email','users.firstname','users.lastname','users.password','users.company_id','users.user_id','users.position','users.active',
            'company.company_name','company.company_state','company.make'
        ],[
            'AND'=>$where,
            'LIMIT'=>[$pageNumber,$limit]
        ]);

        return $result;
    }

    /**
     * Search and get user brief data + company brief data
     * @param $emailOrFirstName
     * @param int $pageNumber
     * @param null $limit
     * @return array|bool
     */
    public static function SearchByEmailOrFirstName($emailOrFirstName, $pageNumber = 0, $limit = null){
        if(is_null($limit)){
            $limit = env('PAGE_SIZE');
        }

        $temp = explode(' ',$emailOrFirstName,2);
        $lastName = null;
        if(count($temp) > 1){
            $emailOrFirstName = $temp[0];
            $lastName = trim($temp[1]);
        }
        if($lastName){
            $where = [
                'users.active'=>1,
                'company.parent_id'=>8,
                "users.firstname[~]" => $emailOrFirstName,
                "users.lastname[~]" => $lastName,
                'users.position'=>[
                    self::RETAIL_SALES_CONSULTANTS,
                    self::FLEET_SALES_CONSULTANTS,
                    self::FLEET_SALES_MANAGER,
                    self::SALES_MANAGER,
                    self::SERVICE_ADVISERS,
                    self::STOCK_CONTROLLER,
                    self::FINANCE_CONTROLLER,
                    self::PARTS_MANAGER,
                    self::PARTS_SALES_REP,
                    self::SERVICE_MANAGER,
                    self::FI,
                ]
            ];
        }else{
            $where = [
                'users.active'=>1,
                'company.parent_id'=>8,
                'OR'=>[
                    "users.firstname[~]" => $emailOrFirstName,
                    "users.lastname[~]" => $emailOrFirstName
                ],
                'users.position'=>[
                    self::RETAIL_SALES_CONSULTANTS,
                    self::FLEET_SALES_CONSULTANTS,
                    self::FLEET_SALES_MANAGER,
                    self::SALES_MANAGER,
                    self::SERVICE_ADVISERS,
                    self::STOCK_CONTROLLER,
                    self::FINANCE_CONTROLLER,
                    self::PARTS_MANAGER,
                    self::PARTS_SALES_REP,
                    self::SERVICE_MANAGER,
                    self::FI,
                ]
            ];
        }

        $db = self::DB();
        $result = $db->select('users',[
            // The row company_id from table users is equal the row company_id from table company
            "[>]company" => ["company_id" => "company_id"],
        ],[
            'users.email','users.firstname','users.lastname','users.company_id','users.user_id','users.position','users.active',
            'company.company_name','company.company_state','company.make'
        ],[
            'AND'=>$where,
            'LIMIT'=>[$pageNumber,$limit]
        ]);

        return $result;
    }

    /**
     * Get the user's dollar reward range
     * @return array
     */
    public function getDollarRewardsRange(){
        $result = [];
        switch ($this->position){
            case self::FI:
                $result=[300,600,1000,1500];
                break;
            case self::FLEET_SALES_MANAGER:
                $result=[500,1000,1500,2000];
                break;
            case self::RETAIL_SALES_CONSULTANTS:
                $result=[500,1000,1500,2000];
                break;
            case self::FLEET_SALES_CONSULTANTS:
                $result=[500,1000,1500,2000];
                break;
            case self::SALES_MANAGER:
                $result=[500,1000,1500,2000];
                break;
            case self::SERVICE_ADVISERS:
                $result=[150,400,1000,1500];
                break;
            case self::STOCK_CONTROLLER:
                $result=[150,400,1000,1500];
                break;
            case self::FINANCE_CONTROLLER:
                $result=[300,600,1000,1500];
                break;
            case self::PARTS_MANAGER:
                $result=[150,400,1000,1500];
                break;
            case self::PARTS_SALES_REP:
                $result=[150,400,1000,1500];
                break;
            case self::SERVICE_MANAGER:
                $result=[150,400,1000,1500];
                break;
            default:
                break;
        }
        return $result;
    }

    public function getGagaDataRange(){
        return $this->getDollarRewardsRange();
    }

    /**
     * Save User
     * @return \App\core\Model|bool
     */
    public function save()
    {
        $this->active = strtolower($this->active) == 'inactive' || empty($this->active) ? 0 : 1;


        if($this->registered){
            $this->registered = strtolower($this->registered) == 'registered' || $this->registered == '1' ? 1 : 0;
        }

        if($this->member){
            $this->member = strtolower($this->member) == 'y' || strtolower($this->member) == 'yes' ? 1 : 0;
        }

        // Make sure the company ID field is correct

        $this->parent_id = 8;   // For nissan ONLY

        if($this->position){
            $this->position = strtoupper($this->position);
        }

        if($this->company_code){
            $row = Company::GetByCompanyCode($this->company_code);
            if($row){
                $this->company_id = $row['company_id'];
            }
        }

        return parent::save(); // TODO: Change the autogenerated stub
    }

    /**
     * Init user's basic info about company and position ...
     * @return $this
     */
    public function init(){
        // Todo: check if the user is in management team
        if(in_array($this->position, $this->_getRegionStaffRoles())){
            $this->managedRegions = [$this->alt_position];
        }elseif ($this->position === self::SHOP_OWNER){
            // A shop owner
            $this->ownedDealers = ManagerDealer::LoadByManager($this);
        }else{
            // Load the user, then load the user's company at the same time
            $this->setCompany();
            // Get user's department name and position desc
            $this->setDepartmentNameAndPositionDesc();
            // Get user's Positions
            $this->positions = DataSource::GetPositionList($this);
            $this->setIsUserRegisteredAndExcellent();
        }
        return $this;
    }

    /**
     * Return region staff position abbr array
     * @return array
     */
    private function _getRegionStaffRoles(){
        return [
            self::NATIONAL_SALES_MANAGER,
            self::DISTRICT_SALES_MANAGER,
            self::RSM,
            self::FOM,
            self::FDM,
            self::RAM,
            self::DTS,
            self::ROA,
            self::RSC,
            self::RSM_NFSA,
            self::DAM_NFSA,
            self::RM_NFSA,
            self::RGM,
            self::ADMIN
        ];
    }

    /**
     * Get is user registered from rankings table
     */
    public function setIsUserRegisteredAndExcellent(){
        $ranking = new Ranking();
        $result = $ranking->getLastRankingByUser($this);
//        dd($result);
        if($result){
            $this->registered = $result->registered===Ranking::REGISTERED || $result->registered==='Registered';
            $this->excellence = $result->calc_dlr_exc ? $result->dlr_excellence_bonus : 0;
        }
    }

    /**
     * Getter for managedRegions
     * @return array|null
     */
    public function getManagedRegions(){
        return $this->managedRegions;
    }

    /**
     * Is the current user is districts sales manager
     * @return bool
     */
    public function isRegionsManager(){
        return !is_null($this->managedRegions);
    }

    /**
     * Getter for ownedDealers
     * @return array|null
     */
    public function getOwnedDealers(){
        return $this->ownedDealers;
    }

    /**
     * Is the current user is dealers owner
     * @return bool
     */
    public function isDealersOwner(){
        return !is_null($this->ownedDealers);
    }

    /**
     * Get current user's positions
     * @return array|null
     */
    public function getPositions(){
        return $this->positions;
    }

    /**
     * User login check: Only Nissan active user can login
     * @param $username
     * @param $password
     * @return User|null
     */
    public function login($username, $password)
    {
        $record = $this->first(
            [
                'AND'=>[
                    'email'     =>$username,
                    'password'  =>$password,
                    'active'    =>true,
                ]
            ]
        );

        // Check if the company is suspended
        $company = Company::GetByCompanyCode($record->company_code);
        if(strtoupper($company['company_name']) === 'SUSPENSION FILE'){
            return null;
        }
        return $record ? $this : $record;
    }

    /**
     * Get user's full name
     * @return string
     */
    public function getName(){
        return $this->firstname.' '.$this->lastname;
    }

    /**
     * Set user's company
     * @param Company|null $company
     * @return User
     */
    public function setCompany(Company $company = null){
        if($company){
            $this->company = $company;
        }else{
            if(is_null($this->company))
                $this->company = new Company($this->company_id);
        }

        // Set some shortcuts to access basic company info from user object
        $this->company_name = $this->company->company_name;
        $this->category = $this->company->category;
        $this->region = $this->company->region;
        return $this;
    }

    /**
     * Get User's company
     * @return Company
     */
    public function getCompany(){
        return $this->company;
    }

    /**
     * Set user's department and position shortcuts
     * @return $this
     */
    public function setDepartmentNameAndPositionDesc(){
        $lookup = new Lookup();
        $this->department_name = $lookup->getDepartmentName($this->dept);
        $this->position_desc = $lookup->getPositionDescription($this->position);
        return $this;
    }

    /**
     * Get current user's employee_code field value
     * @return mixed
     */
    public function getEmployeeCode(){
        return $this->rowData['employee_code'];
    }

    /**
     * Alias of getEmployeeCode() function
     * @return mixed
     */
    public function getMemberId(){
        return $this->getEmployeeCode();
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