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
            ['t'=>'Members Guide','url'=>'/dashboard/MembersGuide','a'=>$current=='MembersGuide'],
            ['t'=>'Account','url'=>'/dashboard/Account','a'=>$current=='Account'],
            ['t'=>'Product Challenge','url'=>'/dashboard/ProductChallenge','a'=>$current=='ProductChallenge'],
            ['t'=>'MD Guild','url'=>'/dashboard/MDguild','a'=>$current=='MDguild'],
            ['t'=>'FAQs','url'=>'/dashboard/FAQ','a'=>$current=='FAQ'],
            ['t'=>'HOME','url'=>'/'],
        ];
        echo JsonBuilder::Success($menus);
    }

    /**
     *
     */
    public function load_regional_data(){
        $regions = explode(' ',$this->request->param('regions'));
        $rows = $this->_retrieve_regional_data($regions);

        for($i = 0;$i<count($rows);$i++){
            $rows[$i]['pos'] = RegionTerritoryReport::ShortenPositionString($rows[$i]['pos']);
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
        $rows = RegionTerritoryReport::GetByEmployeeCodeRegionCodes($regions);

        for ($i=0;$i<count($rows);$i++){
            $find = $user->first(['employee_code'=>$rows[$i]['employee_code']],['email','mobile']);
            if($find){
                $rows[$i]['email'] = $find->email;
                $rows[$i]['mobile'] = $find->mobile;
            }
        }

        $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'active_member_list_'.time().'.csv';
        $fileStream = fopen($filePath,'w');

        $writer = Writer::createFromStream($fileStream);

        $csvHeader = [
            'Region Code','Dealer','Employee Code','Name','Dept','Position','Registered','email','mobile'
        ];
        $writer->insertOne($csvHeader);
        $writer->insertAll($rows);

        fclose($fileStream);

        $this->response->file($filePath);
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
        foreach ($regionCollection as $item) {
            $regions[] = $item['region_code'];
        }
        $rows = $this->_retrieve_regional_data($regions);

        $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'territory_report_'.time().'.csv';
        $fileStream = fopen($filePath,'w');

        $writer = Writer::createFromStream($fileStream);

        $csvHeader = [
            'Region Code','Dealer','Category','Dept','Name','Position','YTD',
            'APR '.env('YEAR'),
            'MAY '.env('YEAR'),
            'JUN '.env('YEAR'),
            'JUL '.env('YEAR'),
            'AUG '.env('YEAR'),
            'SEP '.env('YEAR'),
            'OCT '.env('YEAR'),
            'NOV '.env('YEAR'),
            'DEC '.env('YEAR'),
            'JAN '.(env('YEAR')+1),
            'FEB '.(env('YEAR')+1),
            'MAR '.(env('YEAR')+1),
        ];
        $writer->insertOne($csvHeader);
        $writer->insertAll($rows);

        fclose($fileStream);

        $this->response->file($filePath);
        die(0);
    }

    private function _retrieve_regional_data($regions){
        return RegionTerritoryReport::GetByRegionCodes($regions);
    }
}