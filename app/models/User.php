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
use App\models\management\RegionTerritoryReport;
use App\models\nissan\DataSource;
use App\core\contracts\support\MailTrait;
use App\models\nissan\Ranking;
use App\models\role\IRole;
use Carbon\Carbon;

class User extends BaseModel implements Mailable, IRole
{
    use MailTrait;

    const TABLE_NAME = 'users';

    // Nissan user's position define
    const RETAIL_SALES_CONSULTANTS  = 'R';
    const FLEET_SALES_EXECUTIVES    = 'F';  // added for 2019
    const SALES_MANAGER             = 'M';
    const SERVICE_ADVISERS          = 'SA';
    const STOCK_CONTROLLER          = 'SC';
    const FINANCE_CONTROLLER        = 'C';
    const PARTS_MANAGER             = 'PM';
    const PARTS_SALES_REP           = 'PS';
    const SERVICE_MANAGER           = 'SM';
    const FI                        = 'I';

    // position that currently using
    const DSM = 'DSM'; 
    const DISTRICT_SALES_MANAGER_FULL = 'DISTRICT SALES MANAGER';
    const DISTRICT_SALES_MANAGER    = 'DSM';

    const DTS = 'DTS';
    const DEALER_TECHNICAL_SPECIALIST = 'DEALER TECHNICAL SPECIALIST';

    const FDM = 'FDM';
    const FRANCHISE_DEVELOPMENT_MANAGER = 'FRANCHISE DEVELOPMENT MANAGER';
    const FOM = 'FOM';
    const FIELD_OPERATION_MANAGER = 'FIELD OPERATION MANAGER';
    const HEAD_OFFICE='HEAD OFFICE';
    const NFSA = 'NFSA';
    const RAM = 'RAM';
    const REGIONAL_AFTER_SALES_MANAGER = 'REGIONAL AFTER SALES MANAGER';
    const RFM = 'RFM';
    const REGIONAL_FLEET_MANAGER = "REGIONAL FLEET MANAGER"; 

    const RGM = 'RGM';
    const REGIONAL_GENERAL_MANAGER='REGIONAL GENERAL MANAGER';
    const ROA = 'ROA';
    const REGIONAL_OPERATIONS_ANALYST='REGIONAL OPERATIONS ANALYST';
    const ROM = 'ROM';
    const REGIONAL_OPERATIONS_MANAGER='REGIONAL OPERATIONS MANAGER';
    const RSC = 'RSC';
    const REGIONAL_SALES_COORDINATOR='REGIONAL SALES COORDINATOR';
    const RSM = 'RSM';
    const REGIONAL_SALES_MANAGER='REGIONAL SALES MANAGER'; 
    const TRAINING = 'TRAINING';

    const ADMIN = 'ADMIN';


    //currently not using -- begin
    const PDM = 'PDM';//
    const DAM_NFSA = 'DAM NFSA'; //
    const DESTINATION = 'DESTINATION'; //
    const GENERAL_MANAGER='General Manager'; //

    
    const REGION_STAFF    = 'region_staff';
    const NATIONAL_SALES_MANAGER    = 'GSM';
    const NATIONAL_SALES_MANAGER_FULL    = 'General Sales Manager';
    const RSM_NFSA = 'RSM NFSA';
    const RM_NFSA = 'RM NFSA';
    const NISSAN_SUPER = 'NISSAN_SUPER';
    const SHOP_OWNER = 'SHOP_OWNER';
    //end

    public static $REGIONS_MAP = [ //for regional staff edit
        'SOUTHERN'               =>RegionTerritoryReport::REGION_SOUTHERN,
        'WESTERN & CENTRAL'      =>RegionTerritoryReport::REGION_WESTERN_AND_CENTRAL,
        'EASTERN'                =>RegionTerritoryReport::REGION_EASTERN,
        'NORTHERN'               =>RegionTerritoryReport::REGION_NORTHERN,
        self::HEAD_OFFICE           =>self::HEAD_OFFICE,
        self::NFSA              =>self::NFSA
    ];

    const POSITION_FULLNAME_MAP = [
        self::DSM => self::DISTRICT_SALES_MANAGER_FULL,
        self::DTS => self::DEALER_TECHNICAL_SPECIALIST,
        self::FDM => self::FRANCHISE_DEVELOPMENT_MANAGER,
        self::FOM => self::FIELD_OPERATION_MANAGER,
        self::RAM => self::REGIONAL_AFTER_SALES_MANAGER,
        self::RFM => self::REGIONAL_FLEET_MANAGER,
        self::RGM => self::REGIONAL_GENERAL_MANAGER,
        self::ROA => self::REGIONAL_OPERATIONS_ANALYST,
        self::ROM => self::REGIONAL_OPERATIONS_MANAGER,
        self::RSC => self::REGIONAL_SALES_COORDINATOR,
        self::RSM => self::REGIONAL_SALES_MANAGER,
    ];

    public static $REGION_STAFF_POSITIONS = [
        self::DSM,
        self::DTS,
        self::FDM,
        self::FOM,
        self::HEAD_OFFICE,
        self::NFSA,
        self::RAM,
        self::RFM,
        self::RGM,
        self::ROA,
        self::ROM,
        self::RSC,
        self::RSM,
        self::TRAINING,
    ];

    public static $REGION_STAFF_POSITIONS_WITH_SUPER = [
        self::DSM,
        self::DTS,
        self::FDM,
        self::FOM,
        self::HEAD_OFFICE,
        self::NFSA,
        self::RAM,
        self::RFM,
        self::RGM,
        self::ROA,
        self::ROM,
        self::RSC,
        self::RSM,
        self::TRAINING,
        self::DESTINATION,
    ];

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

    /**
     * Holder for a manager role's members
     * @var array
     */
    public $teamMembers = [];

    public function __construct($id = null)
    {
        parent::__construct($id);
        if($id){
            $this->init();
        }
    }

    /**
     * Get Nissan Users positions
     * @return array
     */
    public static function GetNissanUsersPosition(){
        return [
            self::RETAIL_SALES_CONSULTANTS,
            self::FLEET_SALES_EXECUTIVES,
            self::SALES_MANAGER,
            self::SERVICE_ADVISERS,
            self::STOCK_CONTROLLER,
            self::FINANCE_CONTROLLER,
            self::PARTS_MANAGER,
            self::PARTS_SALES_REP,
            self::SERVICE_MANAGER,
            self::FI,
        ];
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
     * get super admin count
     *
     * @return void
     */
    public static function GetNissanSuperUsersCount(){
        $where = [
            'users.parent_id'=>8,
            'users.company_id'=>8,
            'users.alt_position'=>self::ADMIN,
        ];
        $db = self::DB();
        $result = $db->count('users',$where);

        return $result;

    }

    /**
     * Get nissan super users
     * @return array|bool
     */
    public static function GetNissanSuperUsers($pageNumber = 0, $limit = 20){
        $where = [
            'users.parent_id'=>8,
            'users.company_id'=>8,
            'users.alt_position'=>self::ADMIN,
        ];

        $db = self::DB();
        $result = $db->select('users','*',[
            'AND'=>$where,
            'LIMIT'=>[$pageNumber,$limit]
        ]);

        return $result;
    }

    /**
     * get regional staff count
     *
     * @return void
     */
    public static function GetRegionStaffCount(){
        $where = [
            'users.parent_id'=>8,
            'users.company_id'=>8,
            'users.position'=>User::$REGION_STAFF_POSITIONS
        ];
        $db = self::DB();
        $result = $db->count('users',$where);

        return $result;

    }

    /**
     * Get region staff
     * @param array $options
     * @param int $pageNumber
     * @param int $limit
     * @return array|bool
     */
    public static function GetRegionStaff($options=[], $sortCondition, $pageNumber = 0, $limit = 20){
        if(count($options)>0){
            $where = [
                'users.parent_id'=>8,
                'users.company_id'=>8,
                'users.position'=>User::$REGION_STAFF_POSITIONS
            ];
            foreach ($options as $fieldName=>$value){
                $where[$fieldName] = $value;
            }
        }else{
            $where = [
                'users.parent_id'=>8,
                'users.company_id'=>8,
                'users.position'=>User::$REGION_STAFF_POSITIONS
            ];
        }

        $db = self::DB();
        $condition = [
            'AND'=>$where,
        ];
        if($sortCondition){
            $condition['ORDER'] = [
                $sortCondition['sortBy'] => $sortCondition['order'],
            ];
        }else{
            $condition['ORDER'] = [
                'alt_position'=>'ASC',
                'firstname'=>'ASC',
            ];
        }
        if($limit != null) $condition['LIMIT'] = [$pageNumber*$limit,$limit];
        $result = $db->select('users','*',$condition);

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
            $limit = configuration('PAGE_SIZE');
        }

        if(count($options)>0){
            $where = [
                'users.active'=>1,
                'company.parent_id'=>8,
                'users.position'=>self::GetNissanUsersPosition(),
            ];
            foreach ($options as $fieldName=>$value){
                $where[$fieldName] = $value;
            }
        }
        else{
            $where = [
                'users.active'=>1,
                'company.parent_id'=>8,
                'users.position'=>self::GetNissanUsersPosition(),
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
     * Count Nissan Users
     * @param array $options
     * @return bool|int|mixed|string
     */
    public static function Count($options=[]){
        if(count($options)>0){
            $where = [
                'users.active'=>1,
                'users.parent_id'=>8,
                'users.position'=>self::GetNissanUsersPosition()
            ];
            foreach ($options as $fieldName=>$value){
                $where[$fieldName] = $value;
            }
        }
        else{
            $where = [
                'users.active'=>1,
                'users.parent_id'=>8,
                'users.position'=>self::GetNissanUsersPosition()
            ];
        }

        $db = self::DB();
        return $db->count('users',$where);
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
            $limit = configuration('PAGE_SIZE');
        }

        $positions = self::GetNissanUsersPosition();
        $positions = array_merge($positions,self::$REGION_STAFF_POSITIONS);

        $temp = explode(' ',$emailOrFirstName,2);
        $lastName = null;
        if(count($temp) > 1){
            $emailOrFirstName = $temp[0];
            $lastName = trim($temp[1]);
        }
        if($lastName){
            $where = [
                'users.active'=>1,
                'company.parent_id'=>[8,0],
                "users.firstname[~]" => $emailOrFirstName,
                "users.lastname[~]" => $lastName,
                'users.position'=>$positions
            ];
        }else{
            $where = [
                'users.active'=>1,
                'company.parent_id'=>[8,0],
                'OR'=>[
                    "users.firstname[~]" => $emailOrFirstName,
                    "users.lastname[~]" => $emailOrFirstName,
                    "users.employee_code" => $emailOrFirstName
                ],
                'users.position'=>$positions
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

//        foreach ($db->log() as $item) {
//           echo $item;
//        }

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
                $result=[[100,500,850,1000],[11000,20000,27000,36000]];
                break;
            case self::FLEET_SALES_EXECUTIVES:
                $result=[[100,750,1500,2000],[12000,18000,27000,38000]];
                break;
            case self::RETAIL_SALES_CONSULTANTS:
                $result=[[100,750,1500,2000],[12000,18000,27000,38000]];
                break;
            case self::SALES_MANAGER:
                $result=[[100,750,1500,2000],[12000,18000,27000,38000]];
                break;
            case self::SERVICE_ADVISERS:
                $result=[[100,500,1000,1500],[9000,14000,23000,33000]];
                break;
            case self::STOCK_CONTROLLER:
                $result=[[100,500,850,1000],[10000,14000,18000,24000]];
                break;
            case self::FINANCE_CONTROLLER:
                $result=[[100,500,850,1000],[8000,12000,16000,20000]];
                break;
            case self::PARTS_MANAGER:
                $result=[[100,500,1000,1500],[9000,14000,23000,33000]];
                break;
            case self::PARTS_SALES_REP:
                $result=[[100,500,1000,1500],[9000,14000,23000,33000]];
                break;
            case self::SERVICE_MANAGER:
                $result=[[100,500,1000,1500],[9000,14000,23000,33000]];
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
     * Save User INELIGIBLE
     * @return \App\core\Model|bool
     */
    public function save()
    {
        // Todo: handle user's account active status
        $this->active =
            strtolower($this->active) == 'inactive' ||
            strtolower($this->active) == 'ineligible' ||
            empty($this->active) ? 0 : 1;
        // Check user's position, if it's D or 'N/A', then turn off the active status
        if($this->position === 'D' || $this->position === 'N/A'){
            $this->active = 0;
        }

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

        $this->lastname = str_replace('?','\'',utf8_decode($this->lastname));

        try {
            if (strlen($this->dob) == 8) {
                $this->dob = Carbon::createFromFormat('Ymd', $this->dob)->toDateTimeString();
            }
        } 
        catch(Exception $e) {}

        try {
            if (strlen($this->date_created) == 8) {
                $this->date_created = Carbon::createFromFormat('Ymd', $this->date_created)->toDateTimeString();
            }
        } catch(Exception $e) {}

        if ($this->met_criteria == 'YES') {
            $this->met_criteria = 1;
        }
        if ($this->met_criteria == 'NO') {
            $this->met_criteria = 0;
        }

        return parent::save(); // TODO: Change the autogenerated stub
    }

    /**
     * Is the user is a manager
     * @return bool
     */
    public function isManagerRole(){
        $result = false;
        switch ($this->position){
            case self::PARTS_MANAGER:
                $result = true;
                break;
            case self::SERVICE_MANAGER:
                $result = true;
                break;
            case self::SALES_MANAGER:
                $result = true;
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * Get member roles by given position
     * @param  string $position
     * @return array
     */
    public function getMemberRoles($position = null){
        $result = [];
        if(is_null($position)){
            $position = $this->position;
        }
        switch ($position){
            case self::PARTS_MANAGER:
                $result = [self::PARTS_SALES_REP];
                break;
            case self::SERVICE_MANAGER:
                $result = [self::SERVICE_ADVISERS];
                break;
            case self::SALES_MANAGER:
                $result = [self::RETAIL_SALES_CONSULTANTS,self::FLEET_SALES_EXECUTIVES];
                break;
            default:
                break;
        }
        return $result;
    }

    /**
     * Getter of team members array
     * @return array
     */
    public function getTeamMembers(){
        return $this->teamMembers;
    }

    /**
     * Get users array by given roles
     * @param array $roles
     * @return array|bool
     */
    public function getUsersByRoles($roles = [])
    {
        if(empty($roles)){
            return [];
        }else{
            $database = self::DB();
            $result = $database->select(self::TABLE_NAME,'*',[
                'company_code'=>$this->company_code,
                'active'=>1,
                'position'=>$roles,
                'ORDER'=>[
                    'position' => 'ASC',
                    'firstname'=>'ASC'
                ]
            ]);
            return $result;
        }
    }

    /**
     * get team members by user role
     *
     * @param [object] $user
     * @param [array] $code
     * @return void
     */
    public function getTeamMembersByRole($user,$param)
    {
        $members = [];
        $order = [
            'lookups.content' => 'ASC',
            'firstname'=>'ASC'
        ];
        
        if($user && $user->position){
            $database = self::DB();
            if($param['sortBy'] && $param['order']){
                $order = [
                    $param['sortBy'] => $param['order']
                ];
            }
            $members = $database->select(self::TABLE_NAME,
                [
                    '[>]nissan_region_territory_reports' => ["employee_code" => "employee_code"],
                    '[>]lookups' => ["position" => "code"]
                ],
                '*',
                [
                'users.company_code'=>$user->company_code,
                'users.active'=>1,
                'users.position'=>$user->getMemberRoles(),
                'lookups.company_id'=>8,
                'lookups.grouping'=>'POSITION',
                'ORDER'=>$order,
            ]);
        }
        return $members;
    }

    /**
     * get users by company code
     *
     * @param [string] $code
     * @param [array] $code
     * @return void
     */
    public function getTeamMembersByCompanyCode($code,$param)
    {
        $members = [];
        $order = [
            'lookups.content' => 'ASC',
            'firstname'=>'ASC'
        ];

        /* 
        select * FROM 
        users 
        left join nissan_region_territory_reports  n ON n.employee_code = users.employee_code
        left join lookups ON users.POSITION=CODE
        WHERE
            company_code                =30390 and
            users.active=1 and
            lookups.company_id=8 and
            lookups.grouping='POSITION'   */


        if($code){
            $database = self::DB();
            if($param['sortBy'] && $param['order']){
                $order = [
                    $param['sortBy'] => $param['order']
                ];
            }
            $members = $database->select(self::TABLE_NAME,
                [
                    '[>]nissan_region_territory_reports' => ["employee_code" => "employee_code"],
                    '[>]lookups' => ["position" => "code"]
                ],
                '*',
                [
                'company_code'=>$code,
                'users.active'=>1,
                'lookups.company_id'=>8,
                'lookups.grouping'=>'POSITION',
                'ORDER'=>$order,
                'period'=>configuration('YEAR')
            ]);
        }
        return $members;
    }

    /**
     * Init user's basic info about company and position ...
     * @return $this
     */
    public function init(){
        // Todo: check if the user is in management team
        if(($this->alt_position === self::ADMIN) || ($this->position == self::NFSA) || ($this->position == self::HEAD_OFFICE)){
            $this->managedRegions = [
                Company::REGION_EASTERN,
                Company::REGION_NORTHERN,
                Company::REGION_SOUTHERN,
                Company::REGION_WESTERN,
            ];
        }elseif(in_array($this->position, $this->_getRegionStaffRoles())){
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
            //$this->setIsUserRegisteredAndExcellent();

            $this->registered = $this->rowData['registered']===Ranking::REGISTERED || $this->rowData['registered']==='Registered' || $this->rowData['registered'] === '1';

            if($this->isManagerRole()){
                $this->teamMembers = $this->getUsersByRoles($this->getMemberRoles());
            }
        }
        return $this;
    }

    /**
     * Return region staff position abbr array
     * @return array
     */
    private function _getRegionStaffRoles(){
        return self::$REGION_STAFF_POSITIONS;
    }

    /**
     * Get is user registered from rankings table
     */
    public function setIsUserRegisteredAndExcellent(){
        $ranking = new Ranking();
        $result = $ranking->getLastRankingByUser($this);
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
     * Is the current user is super user
     * @return bool
     */
    public function isSuperUser(){
        return $this->position === self::NISSAN_SUPER;
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
