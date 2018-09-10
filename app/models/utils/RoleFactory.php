<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 7/8/18
 * Time: 1:36 PM
 */

namespace App\models\utils;
use App\models\BaseModel;
use App\models\Company;
use App\models\management\RegionTerritoryReport;
use App\models\nissan\Credit;
use App\models\nissan\Ranking;
use App\models\User;
use App\models\role\FI;
use App\models\role\FinanceController;
use App\models\role\PartsManager;
use App\models\role\RetailSalesConsultant;
use App\models\role\FleetSalesManager;
use App\models\role\FleetSalesConsultant;
use App\models\role\SalesManager;
use App\models\role\StockController;
use App\models\role\PartsSalesRep;
use App\models\role\ServiceManager;
use App\models\role\ServiceAdviser;
use App\models\role\IRole;
class RoleFactory
{
    /**
     * @param $roleAbbr
     * @param User $user
     * @return IRole
     */
    public static function GetRole($roleAbbr, User $user){
        /**
         * @var IRole $role
         */
        $role = null;

        switch ($roleAbbr){
            case User::FI:
                $role = new FI($user);  // Refined
                break;
            case User::FINANCE_CONTROLLER:
                $role = new FinanceController($user); // Refined
                break;
            case User::PARTS_MANAGER:
                $role = new PartsManager($user);    // Refined
                break;
            case User::RETAIL_SALES_CONSULTANTS:
                $role = new RetailSalesConsultant($user);   // Refined
                break;
            case User::FLEET_SALES_CONSULTANTS:
                $role = new FleetSalesConsultant($user);
                break;
            case User::FLEET_SALES_MANAGER:
                $role = new FleetSalesManager($user);   // Refined
                break;
            case User::SALES_MANAGER:
                $role = new SalesManager($user);    // Refined
                break;
            case User::STOCK_CONTROLLER:
                $role = new StockController($user);// Refined
                break;
            case User::PARTS_SALES_REP:
                $role = new PartsSalesRep($user);// Refined
                break;
            case User::SERVICE_MANAGER:
                $role = new ServiceManager($user);  // Refined
                break;
            case User::SERVICE_ADVISERS:
                $role = new ServiceAdviser($user); // Refined
                break;
            case Credit::TABLE_NAME:
                $role = new Credit(); // Refined
                break;
            default:
                break;
        }

        return $role;
    }


    /**
     * @param $roleAbbr
     * @param User $user
     * @return BaseModel
     */
    public static function GetModel($roleAbbr, User $user){
        /**
         * @var BaseModel $role
         */
        $role = null;

        switch ($roleAbbr){
            case User::FI:
                $role = new FI($user);  // Refined
                break;
            case User::FINANCE_CONTROLLER:
                $role = new FinanceController($user); // Refined
                break;
            case User::PARTS_MANAGER:
                $role = new PartsManager($user);    // Refined
                break;
            case User::RETAIL_SALES_CONSULTANTS:
                $role = new RetailSalesConsultant($user);   // Refined
                break;
            case User::FLEET_SALES_CONSULTANTS:
                $role = new FleetSalesConsultant($user);
                break;
            case User::FLEET_SALES_MANAGER:
                $role = new FleetSalesManager($user);   // Refined
                break;
            case User::SALES_MANAGER:
                $role = new SalesManager($user);    // Refined
                break;
            case User::STOCK_CONTROLLER:
                $role = new StockController($user);// Refined
                break;
            case User::PARTS_SALES_REP:
                $role = new PartsSalesRep($user);// Refined
                break;
            case User::SERVICE_MANAGER:
                $role = new ServiceManager($user);  // Refined
                break;
            case User::SERVICE_ADVISERS:
                $role = new ServiceAdviser($user); // Refined
                break;
            case User::DISTRICT_SALES_MANAGER:
                $role = new RegionTerritoryReport($user); // Refined
                break;
            case Credit::TABLE_NAME:
                $role = new Credit(); // Refined
                break;
            case Ranking::TABLE_NAME:
                $role = new Ranking();
                break;
            case Company::TABLE_NAME:
                $role = new Company();
                break;
            case User::TABLE_NAME:
                $role = new User();
                break;
            case User::REGION_STAFF:
                $role = new User();
                break;
            default:
                break;
        }

        return $role;
    }
}