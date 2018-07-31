<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 27/7/18
 * Time: 3:27 PM
 */

namespace App\models\role;


interface IRole
{
    const PREMIER_STR       = 'Premier';
    const AMBASSADOR_STR    = 'Ambassador';
    const DIPLOMAT_STR      = 'Diplomat';
    const CONSUL_STR        = 'Consul';
    const DEFAULT_STR       = 'Default';

    /**
     * Get the template's name for the role
     * @return string
     */
    public function getTemplateName();

    public function getMetrics($data);

    public function getDashboardViewData($data,$ytd);
}