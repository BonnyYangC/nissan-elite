<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 7/9/18
 * Time: 1:34 PM
 */

namespace App\controller\backend;
use App\core\BaseController;
use App\models\User;
use App\models\utils\Pagination;
use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use App\models\nissan\DataSource;

class UsersController extends BaseController
{
    public function __construct(Request $request, Response $response, ServiceProvider $serviceProvider = null, App $app = null)
    {
        parent::__construct($request, $response, $serviceProvider, $app);
    }

    public function index(){
        $currentPageNumber = $this->request->param('pn') ? $this->request->param('pn') : 0;
        $whereCondition = [
            'users.active'=>1,
            'users.parent_id'=>8,
        ];
        $this->dataForView['roles'] = DataSource::$_rolesMap;
        $this->dataForView['users'] = User::Listing([],$currentPageNumber);
        $this->dataForView['pagination'] = Pagination::Build(User::TABLE_NAME, $currentPageNumber,$whereCondition);

        $this->render('backend/users');
        return;
    }
}