<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 20/7/18
 * Time: 1:23 PM
 */

namespace App\models;

use App\core\Model;
class BaseModel extends Model
{
    /**
     * BaseModel constructor.
     * If id provided, retrieve from DB
     * @param null $id
     */
    public function __construct($id=null)
    {
        return parent::__construct($id);
    }
}