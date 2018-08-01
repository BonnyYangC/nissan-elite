<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 1/8/18
 * Time: 12:43 PM
 */

namespace App\models\role\status;


class FiStatus extends GageStatus
{
    public function __construct($yearToDate)
    {
        parent::__construct(11000, 25000, 30000, 50000, $yearToDate, 60000);
    }
}