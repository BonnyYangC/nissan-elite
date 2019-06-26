<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 24/7/18
 * Time: 2:27 PM
 */

namespace App\models\nissan;


use App\models\BaseModel;
use App\models\role\IRole;
use App\models\User;
use Carbon\Carbon;

class Ranking extends BaseModel implements IRole
{
    const NOT_REGISTERED    = 'NO';
    const REGISTERED        = 'YES';

    const CURRENT           = 'Current';
    const PREVIOUS          = 'Previous';
    const REGIONAL          = 'Regional';
    const STATE             = 'State';
    const NATIONAL          = 'National';

    const AWARD_STATUS      = 'status';
    const AWARD_PLATINUM    = 'platinum';
    
    const STATUS_ACTIVE = true;
    const STATUS_ACTIVE_TEXT = 'active';
    const STATUS_INACTIVE = false;
    const STATUS_INACTIVE_TEXT = 'inactive';

    const DLR_CALC_YES  = 'YES';
    const DLR_CALC_NO   = 'NO';
    const DLR_CALC      = true;
    const DLR_CALC_NOT  = false;

    const TABLE_NAME        = 'nissan_rankings';
    protected $tableName    = 'nissan_rankings';

    /**
     * Variables for how to show the leader board
     */
    const LEADER_BOARD_TABLE_MAX_ROW = 5;

    /**
     * Count how many record's ranking is lower than give user and ranking in a period
     * 获取在给定时间条件下, 排名比给定 user 要低的
     * @param User $user
     * @param Carbon $carbon
     * @param string $rankingToCompare
     * @return mixed
     */
    public static function countRegionalRankingLessThan(User $user, Carbon $carbon, $rankingToCompare){
        $position = $user->position;
        // if($user->position === User::FLEET_SALES_CONSULTANTS || $user->position === User::FLEET_SALES_MANAGER){
        //     // Use 'IN' condition
        //     $position = [User::FLEET_SALES_CONSULTANTS, User::FLEET_SALES_MANAGER];
        // }

        $where = [
            'AND'=>[
                'nissan_rankings.ranking[<]'=>$rankingToCompare,
                'nissan_rankings.period'    =>$carbon->format('Y-m-d'),
                'role'                      =>$position,
                'company.region'            =>$user->getCompany()->region
            ],
            "ORDER" => "ranking"
        ];

        $category = $user->getCompany()->category;
        if($category){
            $where['AND']['nissan_rankings.category'] = $category;
        }

        $joins = [
            '[><]users'=>['member_id'=>'employee_code'],
            '[><]company'=>['users.company_id'=>'company_id'],
        ];

        $database = self::DB();
        $result = $database->count(
            self::TABLE_NAME,
            $joins,
            '*',
            $where
        );

        if(env('DEV_MODE', false)){
            dump($database->log());
            dump('Ranking model -> countRegionalRankingLessThan action');
        }

        return $result;
    }

    /**
     * Querying the ranking list
     * @param User $user
     * @param Carbon $carbon
     * @param bool $forGivenUserOnly
     * @return array|bool
     */
    public static function Query(User $user, Carbon $carbon, $forGivenUserOnly=false){
        $position = $user->position;
        // if($user->position === User::FLEET_SALES_CONSULTANTS || $user->position === User::FLEET_SALES_MANAGER){
        //     // Use 'IN' condition
        //     $position = [User::FLEET_SALES_CONSULTANTS, User::FLEET_SALES_MANAGER];
        // }

        $where = [
            'AND'=>[
                'role'=>$position,
                'period'=>$carbon->format('Y-m-d')
            ],
            "ORDER" => "ranking"
        ];

        $category = $user->getCompany()->category;
        if($category){
            $where['AND']['nissan_rankings.category'] = $category;
        }

        if($forGivenUserOnly){
            // It means, only query the current user only
            $where['AND']['nissan_rankings.member_id'] = $user->getEmployeeCode();
        }

        $joins = [
            '[><]users'=>['member_id'=>'employee_code'],
            '[><]company'=>['users.company_id'=>'company_id'],
        ];

        $database = self::DB();

        $columns = [
            'nissan_rankings.id',
            'nissan_rankings.period',
            'nissan_rankings.member_id',
            'nissan_rankings.dealer_code',
            'nissan_rankings.ranking',
            'nissan_rankings.category',
            'nissan_rankings.registered',
            'nissan_rankings.total',
            'users.firstname',
            'users.lastname',
            'company.company_name',
            'company.company_state'
        ];

        $result = $database->select(
            self::TABLE_NAME,
            $joins,
            $columns,
            $where
        );

        if(env('DEV_MODE', false)){
            dump($database->log());
            dump('Ranking model -> Query action');
        }

        if($forGivenUserOnly){
            // Because it's just for one person, so return the one dimension array
            if($result && is_array($result) && count($result)>0){
                $result = $result[0];
            }
        }
        return $result;
    }

    /**
     * Get by give role
     * @param $position
     * @param Carbon $period
     * @param $region
     * @return array|bool
     */
    public static function GetByRole($position, Carbon $period, $region){
        $companyJoin = ['users.company_id'=>'company_id'];


        if($region === self::NATIONAL){
            $order = [
                'nissan_rankings.category',
                'nissan_rankings.ranking'
            ];
        }else{
            $order = [
                'company.region',
                'nissan_rankings.category',
                'nissan_rankings.ranking',
            ];
        }

        if($position === User::FLEET_SALES_EXECUTIVES){
            // Use 'IN' condition
            $companyJoin['nissan_rankings.category'] = 'category';

            if($region === self::NATIONAL){
                $order = 'nissan_rankings.ranking';
            }else{
                $order = [
                    'company.region',
                    'nissan_rankings.ranking',
                ];
            }
        }

        $where = [
            'AND'=>[
                'role'=>$position,
                'period'=>$period->format('Y-m').'-01',
                'users.company_code[!]'=>80172
            ],
            "ORDER" => $order
        ];

        $joins = [
            '[><]users'=>['member_id'=>'employee_code'],
            '[><]company'=>$companyJoin,
            '[><]lookups'=>[
                    'company.region'=>'code',
                    'company.parent_id'=>'company_id',
            ],
        ];

        $database = self::DB();

        $columns = [
            'nissan_rankings.id',
            'nissan_rankings.period',
            'nissan_rankings.member_id',
            'nissan_rankings.dealer_code',
            'nissan_rankings.ranking',
            'nissan_rankings.category',
            'nissan_rankings.registered',
            'nissan_rankings.total',
            'nissan_rankings.total_platinum',
            'nissan_rankings.elite_dealer',
            'users.firstname',
            'users.lastname',
            'company.company_name',
            'company.region',
            'company.parent_id',
            'company.company_state'
        ];

        $result = $database->select(
            self::TABLE_NAME,
            $joins,
            $columns,
            $where
        );

        return $result;
    }

    /**
     *
     * 以前通过下面这条语句来提取最新的 period 的值, 在每个交互中都调用, 本地运行花了6秒钟, 疯了吧!!!!!!
     * Before it runs this statement to get the latest period, but it costs 6 seconds to run. THAT'S INSANE!!!!
     * SELECT MAX(`nissan_rankings`.`period`) FROM `nissan_rankings`
           INNER JOIN `users` ON `nissan_rankings`.`role` = `users`.`position`
           INNER JOIN `company` ON `users`.`company_id` = `company`.`company_id` AND `nissan_rankings`.`category` = `company`.`category`
           WHERE `nissan_rankings`.`role` = 'I'
     *
     * @param User $user
     * @param string $role
     * @return Carbon | null
     */
    public static function QueryThisPeriod(User $user, $role = null){
        $database = self::DB();
        $position = $user->position;

        $where = [
            'AND'=>[
                'role'=>$role ?  $role : $position,
                'dealer_code[!]'=>80172
            ]
        ];

        $category = $user->getCompany()->category;
        if($category){
            $where['AND']['category'] = $category;
        }

        /**
         * Medoo us __call() magic function to generate this 'max' shortcut function
         */
        $result = $database->max(
            self::TABLE_NAME,
            'period',
            $where
        );

        if(env('DEV_MODE', false)){
            dump($database->log() );
            dump('QueryThisPeriod action');
        }

        if($result){
            return Carbon::createFromFormat('Y-m-d',$result);
        }
        return null;
    }

    /**
     * Get last record by User
     * @param User $user
     * @return Ranking
     */
    public function getLastRankingByUser(User $user){
        return $this->last([
            'member_id'=>$user->getEmployeeCode()
        ]);
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