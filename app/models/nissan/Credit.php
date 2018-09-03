<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/7/18
 * Time: 11:00 AM
 */

namespace App\models\nissan;
use App\models\BaseModel;
use App\models\role\IRole;
use App\models\User;

class Credit extends BaseModel implements IRole
{
    const TABLE_NAME = 'nissan_credits';
    protected $tableName = 'nissan_credits';

    const CONSUL        = 10000;
    const DIPLOMAT      = 25000;
    const AMBASSADOR    = 30000;
    const PREMIER       = 50000;

    const PREMIER_COLOR       = '#B47C37';
    const AMBASSADOR_COLOR    = '#546E22';
    const DIPLOMAT_COLOR      = '#BC2628';
    const CONSUL_COLOR        = '#525357';

    /**
     *
     * @param User $user
     * @param $year
     * @return array
     */
    public static function QueryByUserAndYearPeriod(User $user, $year){
        $database = self::DB();
        $year = intval($year);
        $from = $year.'-04-01';
        $to = ($year+1).'-03-31';

        $rows = $database->select(
            self::TABLE_NAME,
            '*',
            [
                'AND'=>[
                    'member_id'=>$user->getEmployeeCode(),
                    'period[<>]'=>[
                        $from, $to
                    ]
                ]
            ]
        );

        if(env('DEV_MODE', false)){
            dump($database->log());
            dump('Credit -> QueryByUserAndYearPeriod');
        }

        return self::_handle($rows);
    }

    /**
     * Re construct the database query result rows for view
     * @param $rows
     * @return array
     */
    public static function _handle($rows){
        $credits = [];
        foreach ($rows as $row) {
            $credits[date("M-Y", strtotime($row['period']))] = $row;
        }
        return $credits;
    }

    /**
     * Get the template's name for the role
     * @return string
     */
    public function getTemplateName()
    {
        // TODO: Implement getTemplateName() method.
    }

    public function getMetrics($data)
    {
        // TODO: Implement getMetrics() method.
    }

    public function getDashboardViewData($data, $ytdParam)
    {
        // TODO: Implement getDashboardViewData() method.
    }
}