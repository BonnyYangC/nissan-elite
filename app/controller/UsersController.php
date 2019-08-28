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
        if($this->dataForView['isInternetExplore']){
            // The browser is not supported
            $this->render('user/update_browser');
        }else{
            $this->dataForView['errorMsg'] = session_flash('error_msg');
            // check if session still available
            $userData = session_get('manager_data_array',true); // Check manager data first
            if(is_null($userData)){
                $userData = session_get('user_data_array',true);
            }
            if($userData && isset($userData['id']) && !empty($userData['id'])){
                // Refresh the session data
                $user = new User($userData['id']);
                $uuid = random_str(uniqid());
                $this->_setUserSessionData($uuid, $user);

                $this->dataForView['grid'] = $this->_get3BrandsGridData();
                $this->dataForView['user'] = $user;
                // Render dashboard view
                $this->render('user/entry_point');
            }else{
                // Render login view
                $this->render('user/login');
            }
        }
        return;
    }

    public function nissan_videos(){
        $video = $this->request->param('event');
        $videoId = null;
        $videoTitle = null;
        $videoFile = null;
        if($video == 'nissan-fleet'){
            $videoId = '307202201';
            $videoTitle = 'Nissan Fleet Rocks Vegas';
            $videoFile = env('SITE_URL').'files/nissan_fleet.mp4';
        }elseif ($video == 'nissan-sales'){
            $videoId = '307198872';
            $videoTitle = 'Navara Rocks Vegas';
            $videoFile = env('SITE_URL').'files/nissan_sales.mp4';
        }
        if($videoId){
            if($this->clientAgent->isPhone()){
                $videoFile = 'https://player.vimeo.com/video/'.$videoId.'?autoplay=1&title=0&byline=0&portrait=0';
            }
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <title><?php echo $videoTitle; ?></title>
            </head>

            <body style="background-color: black;overflow: hidden;">
            <div id="player-wrap" style="position:relative;">
                <iframe src="<?php echo $videoFile; ?>" style="position:absolute;top:0;left:0;width:100vw;height:100vh;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <script src="https://player.vimeo.com/api/player.js"></script>
            <script>
                setTimeout(function () {
                    document.getElementById('player-wrap').style.display = 'block';
                },400);
            </script>
            </body>
            </html>
            <?php
        }else{
            $this->render('user/login');
        }
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

                $emailSent = $user->setEmailFrom(configuration('SUPPORT_EMAIL_ADDRESS'),configuration('SUPPORT_EMAIL_NAME'))
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
        return $username === configuration('ADMIN_USER') && $password === configuration('ADMIN_PASSWORD');
    }

    /**
     * User logout
     */
    public function logout(){
        get_session_instance()->destroy();
        $this->response->redirect('/elite_individual')->send();
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
                'src'=>asset($imageAssetPrefix.'tile-nissanelite.png'),
            ],
            [
                'url'=>url('/dashboard/Leaderboards'),
                'src'=>asset($imageAssetPrefix.'tile-rankings.jpg'),
            ],
            [
                'url'=>url('/dashboard/ProductChallenge'),
                'src'=>asset($imageAssetPrefix.'tile-product-challenge.png'),
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
                'url'=>url('/dashboard/Calendar'),
                'src'=>asset($imageAssetPrefix.'tile-calendar.png'),
            ],
            /*
            [
                'url'=>env('dealExcellenceOverviewUrl', ''),
                'src'=>asset($imageAssetPrefix.'tile-dealership.png'),
            ],
            [
                'url'=>url('/dashboard/MDguild'),
                'src'=>asset($imageAssetPrefix.'tile-md-guild.png'),
            ],
            [
                'url'=>'#',
                'src'=>asset($imageAssetPrefix.'tile-worldrewards.jpg'),
            ],*/
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
        return '/elite_individual';
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
        }elseif ($user->isManagerRole()){
            session_set('manager_data_array', [
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
            'email'=>configuration('ADMIN_USER',false)
        ]);
    }
}