<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 19/7/18
 * Time: 11:27 AM
 */

namespace App\controller;
use App\core\BaseController as Controller;
use App\core\contracts\support\Mailable;
use App\core\JsonBuilder;
use App\models\Session;
use Carbon\Carbon;
use Klein\Request;
use Klein\Response;
use App\models\User;

class UsersController extends Controller
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Entry page
     */
    public function login(){
        $this->dataForView['errorMsg'] = session_flash('error_msg');
        // check if session still available
        $userData = session_get('user_data_array',true);
        if($userData && isset($userData['id']) && !empty($userData['id'])){
            // Refresh the session data
            $user = new User();
            $user->find($userData['id']);
            $uuid = random_str(uniqid());
            $this->_setUserSessionData($uuid, $user);

            $this->dataForView['grid'] = $this->_get3BrandsGridData();
            // Render dashboard view
            $this->render('user/entry_point');
        }else{
            // Render login view
            $this->render('user/login');
        }
        return;
    }

    /**
     * Find user's password and send to it's email address
     */
    public function reset_password(){
        /**
         * @var Mailable $user
         */
        $user = null;
        if($this->request->param('email') && filter_var($this->request->param('email'), FILTER_VALIDATE_EMAIL)){
            $user = new User();
            $result = $user->simpleQueryFirst([
                'email' => $this->request->param('email')
            ]);

            if($result && isset($result['user_id']) && !empty($result['user_id'])){
                $this->dataForView['firstname'] = $result['firstname'];
                $this->dataForView['password'] = $result['password'];
                $content = $this->render('email_templates/users/forget_password_reminder',[],[], true);

                $emailSent = $user->setEmailFrom(env('SUPPORT_EMAIL_ADDRESS'),env('SUPPORT_EMAIL_NAME'))
                    ->setEmailSubject('Your password recovered! (DO NOT REPLY)')
                    ->addEmailTo($result['email'],$result['firstname'])
                    ->addEmailContent(Mailable::CONTENT_TYPE_HTML, $content)
                    ->sendEmail();
                if($emailSent){
                    echo JsonBuilder::Success();
                }else{
                    echo JsonBuilder::Error();
                }
            }else{
                echo JsonBuilder::Error();
            }
        }
    }

    /**
     * Is admin user login
     * @param $username
     * @param $password
     * @return bool
     */
    public function _isAdminLogin($username,$password){
        return $username === env('ADMIN_USER') && $password === env('ADMIN_PASSWORD');
    }

    /**
     * User logout
     */
    public function logout(){
        get_session_instance()->destroy();
        $this->response->redirect('/')->send();
    }

    /**
     *  Get grid data for entry page.
     */
    private function _get3BrandsGridData(){
        $imageAssetPrefix = 'images/tiles/images/';
        return [
            [
                'url'=>url('dashboard'),
                'src'=>asset($imageAssetPrefix.'tile-my-dashboard.jpg'),
            ],
            [
                'url'=>url('/dashboard/MembersGuide'),
                'src'=>asset($imageAssetPrefix.'tile-nissanac.jpg'),
            ],
            [
                'url'=>url('/dashboard/Leaderboards'),
                'src'=>asset($imageAssetPrefix.'tile-rankings.jpg'),
            ],
            [
                'url'=>url('/dashboard/ProductChallenge'),
                'src'=>asset($imageAssetPrefix.'nissan-productchallenge.jpg'),
            ],
            [
                'url'=>url('/dashboard/MDguild'),
                'src'=>asset($imageAssetPrefix.'md-guild.jpg'),
            ],
            [
                'url'=>url('/dashboard/Incentives'),
                'src'=>asset($imageAssetPrefix.'tile-incentives.jpg'),
            ],
            [
                'url'=>'http://nissanlearningacademy.com.au/',
                'src'=>asset($imageAssetPrefix.'tile-training.jpg'),
            ],
            [
                'url'=>'http://www.nissan.com.au/Discover/News',
                'src'=>asset($imageAssetPrefix.'whatsnews-nissannews.jpg'),
            ],
            [
                'url'=>'https://www.nissanfeedback.com.au/Report/login.php',
                'src'=>asset($imageAssetPrefix.'tile-ce.jpg'),
            ],
            [
                'url'=>'http://nissan-events.com.au/excellence-fy18/ac/',
                'src'=>asset($imageAssetPrefix.'nissan-doty.jpg'),
            ],
            [
                'url'=>'#',
                'src'=>asset($imageAssetPrefix.'tile-worldrewards.jpg'),
            ],
            [
                'url'=>url('/dashboard/Calendar'),
                'src'=>asset($imageAssetPrefix.'tile-calendar.jpg'),
            ],
        ];
    }

    /**
     * User login verification
     * @return string
     */
    public function verify_user(){
        $email = $this->request->param('email');
        $password = $this->request->param('password');

        // Check if admin user
        if($this->_isAdminLogin($email, $password)){
            try{
                $this->_setAdminSessionData(random_str(uniqid()));
                $this->response->redirect('/admin-panel')->send();
            }catch (\Exception $exception){
                echo 'System error';
            }
            return null;
        }

        $user = new User();
        $loginSuccess = $user->login($email,$password);

        if ( $loginSuccess )
        {
            $uuid = random_str(uniqid());
            $this->_setUserSessionData($uuid, $user);

            // Need generate an uuid and save into session
            $session = new Session();
            $session->insert([
                'sessionid'=>$uuid,
                'user_id'=>$user->getId(),
                'datestamp'=>Carbon::now()
            ]);
        }
        else
        {
            // Login failed
            session_flash('error_msg','These credentials do not match our records.');
        }
        return '/';
    }

    /**
     * Save user data into session
     * @param $uuid
     * @param User $user
     */
    private function _setUserSessionData($uuid,User $user){
        $this->response->cookie('uuid',$uuid,time() + 3600,'/',url());

        session_set(env('SESSION_SEGMENT','_nissanac'), $uuid);

        if($user->isRegionsManager()){
            session_set('region_staff_data_array', [
                'id'=>$user->getId(),
                'name'=>$user->getName()
            ]);
        }else{
            session_set('user_data_array', [
                'id'=>$user->getId(),
                'name'=>$user->getName()
            ]);
        }
    }

    /**
     * Save admin data into session
     * @param $uuid
     */
    private function _setAdminSessionData($uuid){
        $this->response->cookie('uuid',$uuid,time() + 3600,'/',url());

        session_set(env('SESSION_SEGMENT','_nissanac'), $uuid);
        session_set('admin_data_array', [
            'email'=>env('ADMIN_USER',false)
        ]);
    }
}