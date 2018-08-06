<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 12:29 PM
 */

namespace App\models\role;

use App\models\User;
class FleetSalesManager extends RetailSalesConsultant
{
    public $name='fleet_sales_manager';
    public function __construct(User $user = null)
    {
        parent::__construct($user);
    }

    /**
     * Handle parts manager's metrics data
     * @param $data
     * @return array
     */
    public function getMetrics($data){
        return parent::getMetrics($data);
    }

    /**
     * Get the template's name for the role
     * @return string
     */
    public function getTemplateName()
    {
        return $this->name;
    }

    public function getDashboardViewData($data, $ytd)
    {
        // TODO: Implement getDashboardViewData() method.
        return parent::getDashboardViewData($data, $ytd);
    }
}