<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 31/7/18
 * Time: 9:58 AM
 */

namespace App\models\role\status;


class RetailSalesConsultantStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(15000, 20000, 27000, 38000, $yearToDate, 50000);
    }
}