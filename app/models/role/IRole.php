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
    const PREMIER_STR       = 'PREMIER';
    const AMBASSADOR_STR    = 'AMBASSADOR';
    const DIPLOMAT_STR      = 'DIPLOMAT';
    const CONSUL_STR        = 'CONSUL';
    const DEFAULT_STR       = 'DEFAULT';

    /**
     * Get the template's name for the role
     * @return string
     */
    public function getTemplateName();

    public function getMetrics($data);

    public function getDashboardViewData($data,$ytd);
}