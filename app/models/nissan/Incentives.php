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

    const IMAGE_FILE_PATH = '/images/incentives/images/';
    const PDF_FILE_PATH = '/images/incentives/images/pdf/';

    /**
     * Load Nissan Incentives
     * @param string $status
     * @return array|bool
     */
    public static function Load($status = 'CURRENT'){
        $database = self::DB();
        $now = Carbon::now();

        $left = 'finish';
        if(empty($status)){
            $status = self::CURRENT;
        }

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
                'ORDER'=>['start'=>'DESC']
            ]
        );
        return $result;
    }

    /**
     * Load all incentives for backend
     * @return array|bool
     */
    public static function LoadAll(){
        $database = self::DB();
        $result = $database->select(
            self::TABLE_NAME,
            '*',
            [
                'ORDER'=>['start'=>'DESC']
            ]
        );
        return $result;
    }

    /**
     * get Image url
     * @return string
     */
    public function getImageUrl(){
        return asset(self::IMAGE_FILE_PATH).$this->image;
    }

    /**
     * Get pdf file url
     * @return string
     */
    public function getPdfUrl(){
        return asset(self::PDF_FILE_PATH).$this->pdf;
    }

    /**
     * Get upcoming incentives
     * @return array|bool
     */
    public static function GetUpComing(){
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $database = self::DB();
        $result = $database->select(self::TABLE_NAME,'*',[
            'start[>]'=>$today->format('Y-m-d'),
            'ORDER'=>['start'=>'DESC']
        ]);
        return $result;
    }

    /**
     * Get current incentives
     * @param  string $region
     * @return array|bool
     */
    public static function GetCurrent($region = null){
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $database = self::DB();

        if($region){
            if(is_array($region)){
                $result = $database->select(self::TABLE_NAME,'*',[
                    'AND'=>[
                        'start[<=]'=>$today->format('Y-m-d'),
                        'finish[>=]'=>$today->format('Y-m-d'),
                        'region'=> array_merge($region,['All'])
                    ]
                ]);
            }else{
                $result = $database->select(self::TABLE_NAME,'*',[
                    'AND'=>[
                        'start[<=]'=>$today->format('Y-m-d'),
                        'finish[>=]'=>$today->format('Y-m-d'),
                        'region'=> [$region,'All']
                    ]
                ]);
            }

        }else{
            $result = $database->select(self::TABLE_NAME,'*',[
                'AND'=>[
                    'start[<=]'=>$today->format('Y-m-d'),
                    'finish[>=]'=>$today->format('Y-m-d'),
                ]
            ]);
        }
        return $result;
    }

    /**
     * Get just finished incentives: in past three months
     * @param  string $region
     * @return array|bool
     */
    public static function GetJustFinished($region = null){
        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $threeMonthsBefore = Carbon::now()->subMonths(3);
        $database = self::DB();

        if($region){
            $result = $database->select(self::TABLE_NAME,'*',[
                'AND'=>[
                    'finish[<>]'=>[
                        $threeMonthsBefore->format('Y-m-d'),
                        $today->format('Y-m-d')
                    ],
                    'region'=> is_array($region) ? array_merge($region,['All']) : [$region,'All']
                ],
                'ORDER'=>['start'=>'DESC']
            ]);
        }else{
            $result = $database->select(self::TABLE_NAME,'*',[
                'AND'=>[
                    'finish[<>]'=>[
                        $threeMonthsBefore->format('Y-m-d'),
                        $today->format('Y-m-d')
                    ],
                    'region'=>'All'
                ],
                'ORDER'=>['start'=>'DESC']
            ]);
        }
        return $result;
    }

    /**
     * Get past incentives:
     * @param  string $region
     * @return array|bool
     */
    public static function GetPast($region=null){
        $threeMonthsBefore = Carbon::now()->subMonths(3);
        $database = self::DB();
        if($region){
            $result = $database->select(self::TABLE_NAME,'*',[
                'AND'=>[
                    'finish[<]'=>$threeMonthsBefore->format('Y-m-d'),
                    'region'=> is_array($region) ? array_merge($region,['All']) : [$region,'All']
                ],
                'ORDER'=>['start'=>'DESC']
            ]);
        }else{
            // No region passed in, then show all with region===All
            $result = $database->select(self::TABLE_NAME,'*',[
                'AND'=>[
                    'finish[<]'=>$threeMonthsBefore->format('Y-m-d'),
                    'region'=>'All'
                ],
                'ORDER'=>['start'=>'DESC']
            ]);
        }

        return $result;
    }
}