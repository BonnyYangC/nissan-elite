<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 10/8/18
 * Time: 5:35 PM
 */

namespace App\controller\backend;
use App\core\BaseController;
use App\core\JsonBuilder;
use Klein\Request;
use Klein\Response;
use App\models\User;
use App\core\Route;

class ApiController extends BaseController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Search user by give query keyword
     */
    public function users_search(){
        $usersData = User::SearchByEmailOrFirstName(trim($this->request->param('q')));
        if($usersData && count($usersData) > 0){
            echo JsonBuilder::Success($usersData);
        }else{
            echo JsonBuilder::Error();
        }
    }

    public function get_menus(){
        $current = $this->request->param('current');
        $menus = [
            ['t'=>'My dashboard','url'=>'/dashboard','a'=>$current=='dashboard'],
            ['t'=>'Metrics','url'=>'/dashboard/Metrics','a'=>$current==''],
            ['t'=>'Rankings','url'=>'/dashboard/Leaderboards','a'=>$current=='LeaderBoards'],
            ['t'=>'Incentives','url'=>'/dashboard/Incentives','a'=>$current=='Incentives'],
            ['t'=>'Calendar','url'=>'/dashboard/Calendar','a'=>$current=='Calendar'],
            ['t'=>'Members Guide','url'=>'/dashboard/MembersGuide','a'=>$current=='MembersGuide'],
            ['t'=>'Account','url'=>'/dashboard/Account','a'=>$current=='Account'],
            ['t'=>'Product Challenge','url'=>'/dashboard/ProductChallenge','a'=>$current=='ProductChallenge'],
            ['t'=>'MD Guild','url'=>'/dashboard/MDguild','a'=>$current=='MDguild'],
            ['t'=>'FAQs','url'=>'/dashboard/FAQ','a'=>$current=='FAQ'],
            ['t'=>'HOME','url'=>'/'],
        ];
        echo JsonBuilder::Success($menus);
    }
}