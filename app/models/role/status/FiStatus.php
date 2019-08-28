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
        parent::__construct(14000, 20000, 27000, 36000, $yearToDate, 50000);
    }
}