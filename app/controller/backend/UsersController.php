<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 7/9/18
 * Time: 1:34 PM
 */

namespace App\controller\backend;
use App\core\BaseController;
use App\lib\utils\CsvTool;
use App\models\management\RegionTerritoryReport;
use App\models\User;
use App\models\utils\Pagination;
use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use App\models\nissan\DataSource;
use Carbon\Carbon;
use League\Csv\Writer;

class UsersController extends BaseController
{
    public function __construct(Request $request, Response $response, ServiceProvider $serviceProvider = null, App $app = null)
    {
        parent::__construct($request, $response, $serviceProvider, $app);
    }

    /**
     * List dealer users
     */
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

    /**
     * List region staff
     */
    public function region_staff(){
        $currentPageNumber = $this->request->param('pn') ? $this->request->param('pn') : 0;
        $whereCondition = [
            'users.active'=>1,
            'users.parent_id'=>8,
            'users.position'=>User::$REGION_STAFF_POSITIONS
        ];
        $this->dataForView['roles'] = DataSource::$_rolesMap;
        $this->dataForView['users'] = User::GetRegionStaff([],$currentPageNumber);
        $this->render('backend/region_staff');
        return;
    }

    /**
     * Get Nissan super users
     */
    public function super_users(){
        $this->dataForView['users'] = User::GetNissanSuperUsers();
        $this->render('backend/users/super_users');
        return;
    }

    /**
     * Load super user new view
     */
    public function super_user_new(){
       // $this->import_super_users();
        $user = new User($this->request->param('uid'));
        $this->dataForView['user'] = $user;
        $this->render('backend/users/edit_super');
        return;
    }

    /**
     * Load super user edit view
     */
    public function super_user_edit(){
        $user = new User($this->request->param('uid'));
        $this->dataForView['user'] = $user;
        $this->render('backend/users/edit_super');
        return;
    }

    /**
     * Load region staff edit view to create a new account
     */
    public function region_staff_new(){
        $this->dataForView['user'] = new User();
        $this->dataForView['regions'] = RegionTerritoryReport::$REGIONS;
        $this->dataForView['positions'] = User::$REGION_STAFF_POSITIONS;
        $this->render('backend/users/edit_region_staff');
        return;
    }

    /**
     * Load region staff edit view
     */
    public function region_staff_edit(){
        $user = new User($this->request->param('uid'));
        $this->dataForView['user'] = $user;
        $this->dataForView['regions'] = RegionTerritoryReport::$REGIONS;
        $this->dataForView['positions'] = User::$REGION_STAFF_POSITIONS;
        $this->render('backend/users/edit_region_staff');
        return;
    }

    /**
     * Delete region staff
     */
    public function region_staff_delete(){
        $user = new User($this->request->param('uid'));
        $userName = $user->getName();
        if(User::DB()->delete(User::TABLE_NAME,['user_id'=>$this->request->param('uid')])){
            session_flash('msg',['content'=>$userName.' has been removed successfully!','status'=>'success']);
        }else{
            session_flash('msg',['content'=>'System busy, please try again or contact IT person!','status'=>'danger']);
        }
        $this->response->redirect('/admin/region-staff');
        return;
    }

    /**
     * Delete admin use
     */
    public function super_user_delete(){
        User::DB()->delete(User::TABLE_NAME,['user_id'=>$this->request->param('uid')]);
        $this->response->redirect('/admin/users-super');
        return;
    }

    /**
     * Save super user then redirect
     */
    public function super_user_save(){
        $data = $this->request->paramsPost()->get('user');
        if(empty($data['employee_code'])){
            $data['employee_code'] = random_str(uniqid());
        }
        $data['company_id'] = 8;

        $user = new User();
        foreach ($data as $fieldName => $value) {
            $user->$fieldName = $value;
        }

        $user->save();
        $this->response->redirect('/admin/users-super');
        return;
    }

    private function import_super_users(){
        $reader = CsvTool::ReadFile(__DIR__.DIRECTORY_SEPARATOR.'needs_web_access_super_user.csv');
        foreach ($reader as $row) {
            $lastName = trim(str_replace($row[0],'',$row[2]));
            $data = [
                'company_id'=>8,
                'parent_id'=>8,
                'employee_code'=>random_str(uniqid()),
                'email'=>$row[1],
                'firstname'=>$row[0],
                'lastname'=>$lastName,
                'password'=>strtoupper(str_replace(' ','-',$lastName)).'1',
                'position'=>'NISSAN_SUPER',
                'active'=>1,
            ];
            $user = new User();
            foreach ($data as $fieldName => $value) {
                $user->$fieldName = $value;
            }
            $user->save();
        }
    }

    /**
     * Save region staff user then redirect
     */
    public function region_staff_save(){
        $data = $this->request->paramsPost()->get('user');
        $user = new User();
        foreach ($data as $fieldName => $value) {
            $user->$fieldName = $value;
        }

        if($user->save()){
            session_flash('msg',['content'=>$data['firstname'].' '.$data['lastname'].' has been created successfully!','status'=>'success']);
        }else{
            session_flash('msg',['content'=>'System busy, please try again or contact IT person!','status'=>'danger']);
        }
        $this->response->redirect('/admin/region-staff');
        return;
    }

    /**
     * Load user edit view
     */
    public function user_edit(){
        $user = new User($this->request->param('uid'));
        $this->dataForView['user'] = $user;
        $this->render('backend/users/edit');
        return;
    }

    /**
     * Save users
     */
    public function user_save(){
        $data = $this->request->paramsPost()->get('user');
        $user = new User();

        foreach ($data as $fieldName=>$value) {
            $user->$fieldName = $value;
        }

        if($user->save()){
            session_flash('msg',['content'=>$user->firstname.' has been updated successfully!','status'=>'success']);
        }else{
            session_flash('msg',['content'=>'System busy, please try again or contact IT person!','status'=>'danger']);
        }
        $this->response->redirect('/admin/users-manage');
        return;
    }

    /**
     *
     */
    public function users_export(){
        if($this->request->param('type') === 'admin'){
            $users = User::GetNissanSuperUsers();
            $rows = [];
            foreach ($users as $user) {
                $rows[] = [
                    'All Regions',
                    $user['firstname'].' '.$user['lastname'],
                    $user['email'],
                    $user['phone'],
                    $user['password'],
                ];
            }

            // Export admin users
            $today = Carbon::today(env('DEFAULT_TIMEZONE'));

            $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'nissan_admin_'.$today->format('d_M_Y').'.csv';
            $fileStream = fopen($filePath,'w');

            $writer = Writer::createFromStream($fileStream);

            $csvHeader = [
                'Region','Name','Email','Mobile','Password'
            ];
            $writer->insertOne($csvHeader);
            $writer->insertAll($rows);

            fclose($fileStream);

            $this->response->file($filePath,null,'csv');

        }elseif ($this->request->param('type') === 'region'){
            $users = User::GetRegionStaff([]);
            $rows = [];
            foreach ($users as $user) {
                $rows[] = [
                    $user['alt_position'],
                    $user['firstname'].' '.$user['lastname'],
                    $user['email'],
                    $user['phone'],
                    $user['password'],
                    $user['position'],
                    $user['active']==='1' ? 'YES':'NO'
                ];
            }

            // Export admin users
            $today = Carbon::today(env('DEFAULT_TIMEZONE'));

            $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'nissan_region_staff_'.$today->format('d_M_Y').'.csv';
            $fileStream = fopen($filePath,'w');

            $writer = Writer::createFromStream($fileStream);

            $csvHeader = [
                'Region','Name','Email','Mobile','Password','Position','Active'
            ];
            $writer->insertOne($csvHeader);
            $writer->insertAll($rows);

            fclose($fileStream);

            $this->response->file($filePath,null,'csv');
        }
        die(0);
    }
}
