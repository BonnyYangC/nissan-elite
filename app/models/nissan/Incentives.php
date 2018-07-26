<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 3:29 PM
 */

namespace App\models\nissan;
use App\models\BaseModel;
use Carbon\Carbon;

class Incentives extends BaseModel
{
    const TABLE_NAME = 'nissan_incentives';
    protected $tableName = 'nissan_incentives';

    const CURRENT = 'CURRENT';
    const FINISHED = 'FINISHED';
    const PAST = 'PAST';

    /**
     * Load Nissan Incentives
     * @param string $status
     * @return array|bool
     */
    public static function Load($status = 'CURRENT'){
        $database = self::DB();
        $now = Carbon::now();

        $left = 'finish';
        $right = '';

        if($status == self::CURRENT){
            $left .= '[>=]';
            $right = $now->format('Y-m-d');
        }elseif ($status == self::FINISHED){
            $left .= '[<>]';
            $right = [
                Carbon::now()->subMonths(3)->format('Y-m-d'),
                $now->format('Y-m-d')
            ];
        }else{
            $left .= '[<]';
            $right = $now->subMonths(3)->format('Y-m-d');
        }
        $result = $database->select(
            self::TABLE_NAME,
            '*',
            [
                'AND'=>[
                    $left => $right,
                    'image[!]'=>null
                ],
                'ORDER'=>['start']
            ]
        );
        return $result;
    }
}