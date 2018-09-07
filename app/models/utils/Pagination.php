<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 7/9/18
 * Time: 2:04 PM
 */

namespace App\models\utils;
use App\core\Model;

class Pagination extends Model
{
    public static function Build($tableName, $currentPageNumber,$where=[]){
        $database = self::DB();
        $total = $database->count($tableName,'*',$where);
        $result = [
            'total'     =>$total,
            'current'   =>$currentPageNumber,
            'pages'     =>ceil($total/env('PAGE_SIZE')),
        ];
        return $result;
    }
}