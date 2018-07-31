<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 20/7/18
 * Time: 1:24 PM
 */

namespace App\models;


use App\models\nissan\DataSource;

class User extends BaseModel
{
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


    public function __construct($id = null)
    {
        parent::__construct($id);
        if($id){
            $this->init();
        }
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
        // Load the user, then load the user's company at the same time
        $this->setCompany();
        // Get user's department name and position desc
        $this->setDepartmentNameAndPositionDesc();
        // Get user's Positions
        $this->positions = DataSource::GetPositionList($this);
        return $this;
    }

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