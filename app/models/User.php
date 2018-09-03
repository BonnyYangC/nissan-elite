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

class User extends BaseModel implements Mailable
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
    const DISTRICT_SALES_MANAGER    = 'DSM';
    const SHOP_OWNER                = 'SHOP_OWNER';
    const NATIONAL_SALES_MANAGER    = 'NSM';

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
     * Init user's basic info about company and position ...
     * @return $this
     */
    public function init(){
        // Todo: check if the user is in management team
        if($this->position === self::NATIONAL_SALES_MANAGER || $this->position === self::DISTRICT_SALES_MANAGER){
            $this->managedRegions = ManagerRegion::LoadByManager($this);
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
        }
        return $this;
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
}