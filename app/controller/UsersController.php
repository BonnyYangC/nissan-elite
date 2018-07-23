<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 19/7/18
 * Time: 11:27 AM
 */

namespace App\controller;
use App\core\BaseController as Controller;
use App\core\Route;
use App\models\Session;
use Carbon\Carbon;
use Klein\Request;
use App\models\User;
use Klein\Response;

class UsersController extends Controller
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function login(Request $request){
        $this->render('user/login');
        return;
    }

    public function home(){
        dump($this->request->cookies());
        dump(session_get('user_data_array'));
        echo 'home';
        return;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function verify_user(Request $request, Response $response){
        $email = $request->param('email');
        $password = $request->param('password');
        $user = new User();
        $loginSuccess = $user->login($email,$password);

        if ( $loginSuccess )
        {
            $uuid = random_str(uniqid());
            $response->cookie('uuid',$uuid,time() + 3600,'/',url());

            session_set(env('SESSION_SEGMENT','_nissanac'), $uuid);
            session_set('user_data_array', [
                'id'=>$user->getId(),
                'name'=>$user->getName()
            ]);

            // Need generate an uuid and save into session
            $session = new Session();
            $session->insert([
                'sessionid'=>$uuid,
                'user_id'=>$user->getId(),
                'datestamp'=>Carbon::now()
            ]);
            return '/home';
        }
        else
        {
            // Login failed
            session_flash('msg','These credentials do not match our records.');
            return '/';
        }
    }
}