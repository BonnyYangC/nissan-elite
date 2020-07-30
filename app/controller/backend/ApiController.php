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
use App\models\Company;
use App\models\management\RegionTerritoryReport;
use Carbon\Carbon;
use Klein\Request;
use Klein\Response;
use App\models\User;
use League\Csv\Writer;

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

    /**
     * Load Nissan dealers
     */
    public function load_nissan_dealers(){
        $company = new Company();
        $dealers = $company->simpleQuery(['parent_id'=>8],['company_id','company_name']);

        echo JsonBuilder::Success($dealers);
    }

    /**
     * Return menus for mobile version
     */
    public function get_menus(){
        $current = $this->request->param('current');
        $menus = [
            ['t'=>'My dashboard','url'=>'/dashboard','a'=>$current=='dashboard'],
            ['t'=>'Metrics','url'=>'/dashboard/Metrics','a'=>$current==''],
            ['t'=>'Rankings','url'=>'/dashboard/Leaderboards','a'=>$current=='LeaderBoards'],
            ['t'=>'Incentives','url'=>'/dashboard/Incentives','a'=>$current=='Incentives'],
            ['t'=>'Calendar','url'=>'/dashboard/Calendar','a'=>$current=='Calendar'],
            ['t'=>'About the Program','url'=>'/dashboard/AboutProgram','a'=>$current=='AboutProgram'],
            ['t'=>'Members Guide','url'=>'/dashboard/MembersGuide','a'=>$current=='MembersGuide'],
            ['t'=>'Account','url'=>'/dashboard/Account','a'=>$current=='Account'],
            ['t'=>'Product Challenge','url'=>'/dashboard/ProductChallenge','a'=>$current=='ProductChallenge'],
            //['t'=>'Guild','url'=>'/dashboard/MDguild','a'=>$current=='MDguild'],
            ['t'=>'FAQs','url'=>'/dashboard/FAQ','a'=>$current=='FAQ'],
            ['t'=>'HOME','url'=>'/'],
        ];
        echo JsonBuilder::Success($menus);
    }

    /**
     * DSM or Admin user load the regional report data
     */
    public function load_regional_data(){
        $regions = explode(' ',$this->request->param('regions'));
        $rows = $this->_retrieve_regional_data($regions[0]);

        for($i = 0;$i<count($rows);$i++){
            $rows[$i]['p'] = RegionTerritoryReport::ShortenPositionString($rows[$i]['p']);
            $rows[$i]['c'] = $rows[$i]['c']=='Registered'? 'YES':'NO';
        }
        echo JsonBuilder::Success($rows);
    }

    /**
     * DSM download active member list
     */
    public function download_active_member_list(){
        $member = $this->request->param('member');
        $user = new User($member);
        $regionCollection = $user->getManagedRegions();
        $regions = [];
        foreach ($regionCollection as $item) {
            $regions[] = $item['region_code'];
        }
        $rows = RegionTerritoryReport::GetByEmployeeCodeRegionCodes(
            $regions,
            $this->request->param('dept'),
            $this->request->param('dealer')
        );

        for ($i=0;$i<count($rows);$i++){
            $find = $user->first(['employee_code'=>$rows[$i]['employee_code']],['email','mobile']);
            if($find){
                $rows[$i]['email'] = $find->email;
                $rows[$i]['mobile'] = $find->mobile;
            }
        }

        $today = Carbon::today(env('DEFAULT_TIMEZONE'));

        $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'active_member_list_'.$today->format('d_M_Y').'.csv';
        $fileStream = fopen($filePath,'w');

        $writer = Writer::createFromStream($fileStream);

        $csvHeader = [
            'Region Code','Dealer','Member No.','Name','Dept','Position','Registered','email','mobile'
        ];
        $writer->insertOne($csvHeader);
        $writer->insertAll($rows);

        fclose($fileStream);

        $this->response->file($filePath,null,'csv');
        die(0);
    }

    /**
     * DMS download territory report
     */
    public function download_regional_data(){
        $member = $this->request->param('member');
        $user = new User($member);
        $regionCollection = $user->getManagedRegions();
        $regions = [];
        $regionsName = ''; // Used to concat the download file name
        foreach ($regionCollection as $item) {
            $regions[] = $item['region_code'];
//            switch (strtoupper($item['region_code'])){
//                case 'E':
//                    $regionsName .= 'Eastern';
//                    break;
//                case 'N':
//                    $regionsName .= 'Northern';
//                    break;
//                case 'W':
//                    $regionsName .= 'Western_Central';
//                    break;
//                case 'S':
//                    $regionsName .= 'Southern';
//                    break;
//                default:
//                    break;
//            }
        }

        $rows = $this->_retrieve_regional_data(
            $regions,
            $this->request->param('dept'),
            $this->request->param('dealer')
        );

        $today = Carbon::today(env('DEFAULT_TIMEZONE'));
        $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'territory_report_'.$today->format('d_M_Y').'.csv';
        $fileStream = fopen($filePath,'w');

        $writer = Writer::createFromStream($fileStream);

        $csvHeader = [
            'Region',
            'Dealer','Registered','Dept','Name','Member No.','Position','YTD',
            'APR '.configuration('YEAR'),
            'MAY '.configuration('YEAR'),
            'JUN '.configuration('YEAR'),
            'JUL '.configuration('YEAR'),
            'AUG '.configuration('YEAR'),
            'SEP '.configuration('YEAR'),
            'OCT '.configuration('YEAR'),
            'NOV '.configuration('YEAR'),
            'DEC '.configuration('YEAR'),
            'JAN '.(configuration('YEAR')+1),
            'FEB '.(configuration('YEAR')+1),
            'MAR '.(configuration('YEAR')+1),
        ];
        $writer->insertOne($csvHeader);
        $writer->insertAll($rows);

        fclose($fileStream);

        $this->response->file($filePath,null,'csv');
        die(0);
    }

    /**
     * @param $regions
     * @param string $dept
     * @param null $dealerNameKeyword
     * @return array|bool
     */
    private function _retrieve_regional_data($regions,$dept = 'All', $dealerNameKeyword = null){
        return RegionTerritoryReport::GetByRegionCodes($regions,$dept,$dealerNameKeyword);
    }

    public function fake_dealer_team(){
        $dealerCode = $this->request->param('code');
        session_set('api_session',true);
        $this->clean_session();
        $this->dataForView['currentUri'] = 'api/my-team';
        $this->dataForView['dealer_code'] = $dealerCode;
        $this->dataForView['fromApi'] = true;
        $this->dataForView['dashboardMenuOnly'] = true;
        $this->dataForView['dealer'] = Company::GetByCompanyCode($dealerCode);
        $param = [
            'sortBy' => $this->request->param('sortby'),
            'order' => $this->request->param('order'),
        ];
        $this->dataForView['teamMembers'] = User::getTeamMembersByCompanyCode($dealerCode, $param);
        return $this->render('dashboard/my_team');
    }

    public function close_api_session(){
        //clean api session
        if(session_get('api_session',true)){
            session_set('api_session', false);
        }
        //close current tab
        echo "<script>window.close();</script>";
    }

    public function clean_session(){
        //when api session, clean up other session
        session_set('user_data_array', []);
        session_set('manager_data_array', []);
        session_set('region_staff_data_array', []);
    }
}
