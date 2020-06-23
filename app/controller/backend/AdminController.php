<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 6/8/18
 * Time: 5:41 PM
 */

namespace App\controller\backend;

use App\core\BaseController;
use App\lib\utils\CsvTool;
use App\lib\utils\FileUploader;
use App\models\BaseModel;
use App\models\Company;
use App\models\management\RegionTerritoryReport;
use App\models\nissan\Credit;
use App\models\nissan\DataSource;
use App\models\nissan\History;
use App\models\nissan\Ranking;
use App\models\User;
use App\models\utils\RoleFactory;
use Klein\Request;
use Klein\Response;
use App\models\utils\TableFieldMap as DbMap;
use Carbon\Carbon;
use League\Csv\Writer;

class AdminController extends BaseController
{
    /**
     * @var array
     */
    private $indexes = [];
    private $csvFileIndexes = null; // The first row of the csv file, as the index
    private $resultArray = [];
    private $notFoundArray = [];
    private $fieldMap = [];
    /**
     * Result table had td tags only
     * @var string
     */
    private $resultTableHead = '';

    /**
     * 最后一次保存的 Result set
     * @var null
     */
    private $_lastFoundResultSet = null;

    private $allHtml = '<a href="/admin-panel">Go Back</a>&nbsp&nbsp;<a target="_blank" href="/admin-panel">Go Back (new tab)</a><br>';

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Update system env file
     */
    public function updateProjectSettings(){
        /**
         * @var array $env
         */
        $setting = $this->request->param('setting');

        $content = 'PROGRAM_NAME="'.$setting['PROGRAM_NAME'].'"'.PHP_EOL;
        $content .= 'PROGRAM_SHORT_NAME="'.$setting['PROGRAM_SHORT_NAME'].'"'.PHP_EOL;
        $content .= 'PROGRAM_SHORT_NAME_WITH_YEAR="'.$setting['PROGRAM_SHORT_NAME_WITH_YEAR'].'"'.PHP_EOL;
        $content .= 'PROGRAM_I_ELITE="'.$setting['PROGRAM_I_ELITE'].'"'.PHP_EOL;
        $content .= 'PROGRAM_DEALERSHIP="'.$setting['PROGRAM_DEALERSHIP'].'"'.PHP_EOL;
        $content .= 'YEAR='.$setting['YEAR'].PHP_EOL;
        $content .= 'PROGRAM_AWARD_UNIT="'.$setting['PROGRAM_AWARD_UNIT'].'"'.PHP_EOL;
        $content .= 'PRODUCT_CHALLENGE_WINNER="'.$setting['PRODUCT_CHALLENGE_WINNER'].'"'.PHP_EOL;
        $content .= 'PAGE_SIZE='.$setting['PAGE_SIZE'].PHP_EOL;
        $content .= 'SUPPORT_EMAIL_ADDRESS='.$setting['SUPPORT_EMAIL_ADDRESS'].PHP_EOL;
        $content .= 'SUPPORT_EMAIL_NAME="'.$setting['SUPPORT_EMAIL_NAME'].'"'.PHP_EOL;
        $content .= 'ADMIN_USER='.$setting['ADMIN_USER'].PHP_EOL;
        $content .= 'ADMIN_PASSWORD='.$setting['ADMIN_PASSWORD'].PHP_EOL;

        file_put_contents(env('APP_PATH').'/helpers/setting.php',$content);

        $this->response->redirect('/admin-panel');
    }

    /**
     * Load panel
     */
    public function index(){
        // Move 'Region Territory Report' under Summary as last item
        $this->dataForView['roles'] = DataSource::$_rolesMap;
        unset($this->dataForView['roles'][User::DISTRICT_SALES_MANAGER]);

        $this->dataForView['summary'] = [
            /*Credit::TABLE_NAME=>'Nissan Credits',*/
            Ranking::TABLE_NAME=>'Nissan Rankings',
            User::DISTRICT_SALES_MANAGER=>'Region Territory Report'
        ];
        $this->dataForView['users_menu'] = [
            User::TABLE_NAME    =>'User Data',
            Company::TABLE_NAME =>'Dealer Data',
            User::REGION_STAFF  =>'Region Staff',
        ];
        $this->render('backend/index');
        return;
    }

    /**
     * Fake a user to show the his dashboard and metrics
     * @return \Klein\AbstractResponse
     */
    public function fake_user(){
        $fromApi = $this->request->param('fromApi');
        if($fromApi && !session_get('api_session')){
            //redirect to session expire page
            return $this->render('dashboard/static/session_expired');
        }
        $userId = $this->request->param('uid');
        $employeeCode = $this->request->param('uc');
        if($employeeCode){
            $database = User::DB();
            $result = $database->select(User::TABLE_NAME,'*',[
                'employee_code'=>$employeeCode
            ]);
            if($result && count($result)>0){
                $row = $result[0];
                $user = new User($row['user_id']);
            }
        }else{
            $user = new User($userId);
        }

        $uuid = random_str(uniqid());
        $this->response->cookie('uuid',$uuid,time() + 3600,'/',url());

        session_set(env('SESSION_SEGMENT','_nissanac_fake'), $uuid);
        session_set('user_data_array', [
            'id'=>$user->getId(),
            'name'=>$user->getName(),
            'from_user'=>session_get('user_data_array', 'id')
        ]);
        session_set('selected_role',null);

        // redirect to this user's dashboard
        $redirect = '/dashboard';
        return $this->response->redirect($redirect)->send();
    }

    /**
     * @return \Klein\AbstractResponse
     */
    public function fake_user_matrics(){
        $fromApi = $this->request->param('fromApi');
        if($fromApi && !session_get('api_session')){
            //redirect to session expire page
            return $this->render('dashboard/static/session_expired');
        }
        $userId = $this->request->param('uid');
        $employeeCode = $this->request->param('uc');
        if($employeeCode){
            $database = User::DB();
            $result = $database->select(User::TABLE_NAME,'*',[
                'employee_code'=>$employeeCode
            ]);
            if($result && count($result)>0){
                $row = $result[0];
                $user = new User($row['user_id']);
            }
        }else{
            $user = new User($userId);
        }

        $uuid = random_str(uniqid());
        $this->response->cookie('uuid',$uuid,time() + 3600,'/',url());

        session_set(env('SESSION_SEGMENT','_nissanac_fake'), $uuid);
        session_set('user_data_array', [
            'id'=>$user->getId(),
            'name'=>$user->getName()
        ]);
        session_set('selected_role',null);

        // redirect to this user's dashboard
        $redirect = '/dashboard/Metrics';
        return $this->response->redirect($redirect)->send();
    }

    public function fake_region_staff(){
        session_set('user_data_array', null);
        session_set('selected_role',null);

        $userId = $this->request->param('uid');
        $user = new User($userId);
        // Must be a region staff
        $uuid = random_str(uniqid());
        $this->response->cookie('uuid',$uuid,time() + 3600,'/',url());

        session_set(env('SESSION_SEGMENT','_nissanac_fake'), $uuid);
        session_set('region_staff_data_array', [
            'id'=>$user->getId(),
            'name'=>$user->getName()
        ]);

        // redirect to this user's dashboard
        return $this->response->redirect('/dashboard')->send();
    }

    public function jump_to_dealer(){
        $rsd = json_decode(session_get('region_staff_data_array'));
        return $this->response->redirect( env('dealerExcellence') .'/admin/mock/'. md5(rand()). '/'. base64_encode($rsd->id));
    }

    /**
     * @param $roleAbbr
     * @param User $user
     * @param $tableName
     * @return BaseModel
     */
    private function _getANewModel($roleAbbr, User $user, $tableName){
        $model = RoleFactory::GetModel($roleAbbr ,$user);
        $model->setTableName($tableName);
        return $model;
    }

    /**
     * Update the regional report active
     */
    public function sync_regional_report_user_status(){
        /**
         * 下面的代码会根据 csv 文档, 扫描 region_report, activate or inactives
         */
//        $readerActive = CsvTool::ReadFile(__DIR__.'/files/active_member_17sep18_region_report.csv');
//        $countActiveSuccess = 0;
//        $countActiveFailed = 0;
//        foreach ($readerActive as $index=>$row) {
//            if($index > 0){
//                if(RegionTerritoryReport::ActiveIt($row[0])){
//                    $countActiveSuccess++;
//                }else{
//                    $countActiveFailed++;
//                }
//            }
//        }
//
//        $readerInactive = CsvTool::ReadFile(__DIR__.'/files/inactive_member_17sep18_region_report.csv');
//        $countInactiveSuccess = 0;
//        $countInactiveFailed = 0;
//        foreach ($readerInactive as $index=>$row) {
//            if($index > 0){
//                if(RegionTerritoryReport::InactiveIt($row[0],$row[2])){
//                    $countInactiveSuccess++;
//                }else{
//                    $countInactiveFailed++;
//                }
//            }
//        }

        /**
         * 下面的代码会根据 csv 文档, 扫描 nissan_history 表格, 然后更新所有的 2017 的总 credits
         */
        $readerInactive = CsvTool::ReadFile(__DIR__.'/files/historical_sep17.csv');
        foreach ($readerInactive as $index=>$row) {
            if($index > 0){
                $records = History::DB()->select(History::TABLE_NAME,['id','amount'],[
                    'AND'=>[
                        'member_id'=>$row[0],
                        'period'=>'2017-01-01'
                    ],
                    'LIMIT'=>1
                ]);
                if(count($records)>0){
                    $bean = $records[0];
                    if(floatval($row[1]) != $bean['amount']){
                        History::DB()->update(
                            History::TABLE_NAME,
                            ['amount'=>$row[1]],
                            ['id'=>$bean['id']]
                        );
                    }
                }else{
                    $history = new History();
                    $history->period    = '2017-01-01';
                    $history->member_id = $row[0];
                    $history->amount    = $row[1];
                    $history->save();
                }
            }
        }

//        dump('Active: '.$countActiveSuccess);
//        dump('Active failed: '.$countActiveFailed);
//        dump('Inactive: '.$countInactiveSuccess);
//        dump('Inactive failed: '.$countInactiveFailed);
    }

    /**
     * Fix all possible missing data in history table
     */
    public function fix_historical_data_for_credits(){
        $is2017Only = true;

        if($is2017Only){
            $reader = CsvTool::ReadFile(__DIR__.'/history2017.csv');
        }else{
            $reader = CsvTool::ReadFile(__DIR__.'/history.csv');
        }

        $yearsIndex = [
            '2016-01-01',
            '2015-01-01',
            '2015-01-02',
            '2014-01-01',
            '2013-01-01',
            '2012-01-01',
            '2011-01-01',
            '2010-01-01',
            '2009-01-01',
            '2008-01-01',
            '2007-01-01',
            '2006-01-01',
            '2005-01-01',
            '2004-01-01',
            '2003-01-01',
            '2002-01-01',
            '2001-01-01',
            '2000-01-01',
            '1999-01-01',
            '1998-01-01',
            '1997-01-01',
            '1996-01-01',
            '1995-01-01',
            '1994-01-01',
            '1993-01-01',
            '1992-01-01',
        ];
        $database = BaseModel::DB();
        $count = 0;
        foreach ($reader as $index=>$row) {
            if($index>0){
                $employeeId = $row[0];
                if($is2017Only){
                    $period = '2017-01-01';
                    $where = [
                        'AND'=>[
                            'period'    =>$period,
                            'member_id' =>$employeeId
                        ],
                        'LIMIT'=>1
                    ];
                    $histories = $database->select('nissan_history','*',$where);
                    $history = new History();
                    if(isset($histories[0])){
                            $history->id = $histories[0]['id'];
                            $history->amount = $row[1];
                            $history->save();
                    }else{
                        // Missing data, insert it
                        $history->period    = $period;
                        $history->member_id = $employeeId;
                        $history->amount    = $row[1];
                        $history->save();
                        $count++;
                    }
                    $history = null;
                }
                else{
                    foreach (range(1,26) as $idx) {
                        if(!empty($row[$idx])){
                            $where = [
                                'AND'=>[
                                    'period'=>$yearsIndex[$idx-1],
                                    'member_id'=>$employeeId
                                ],
                                'LIMIT'=>1
                            ];
                            $histories = $database->select('nissan_history','*',$where);
                            $history = new History();
                            if(isset($histories[0])){
//                            $history->id = $histories[0]['id'];
//                            $history->amount = $row[$idx];
//                            $history->save();
//                            $updatedCount++;
                            }else{
                                // Missing data, insert it
                                $history->period = $yearsIndex[$idx-1];
                                $history->member_id = $employeeId;
                                $history->amount = $row[$idx];
                                $history->save();
                                $count++;
                            }
                            $history = null;
                        }
                    }
                }
            }
        }
        dump($count);
    }

    /**
     * Cross check or sync database with submitted csv file
     */
    public function csv_importer(){
        ini_set('max_execution_time', 300); 
        $isSyncAction = $this->request->param('action_type') == 'sync';
        $uploader = new FileUploader($this->request);
        $filePath = $uploader->store('csv');
        $syncedRowsCount = 0;

        $date_type_fields = [
            'dob',
            'date_created'
        ];

        $allRowsIgnored = true;


        if($filePath){
            /**
             * @var File $file
             */
            if (file_exists($filePath)) {
                $user = new User();
                $roleAbbr = $this->request->param('for');
                $tableName = DataSource::nissan_get_table_name_from_abbr($roleAbbr);
//                $model = $this->_getANewModel($roleAbbr, $user, $tableName);

                // Call any method on an SplFileInfo instance
                $reader = CsvTool::ReadFile($filePath);

                foreach ($reader as $index=>$row) {
                    if($index === 0){
                        $this->csvFileIndexes = $row;
                        $csvColHeaders = $row;
                        $this->_matchDbFields($row, $tableName, $roleAbbr);
                        $map = $this->_matchDbFields($row, $tableName, $roleAbbr, true);
                        break;
                    }
                }

                /**
                 * Get database connection
                 */
                $db = BaseModel::DB();

                foreach ($reader as $index=>$row) {

                    if(
                        $index > 0 &&
                        (
                            !empty($row[$this->indexes[DbMap::MEMBER_ID]]) ||
                            !empty($row[$this->indexes[DbMap::EMPLOYEE_CODE]]) ||  //regi#
                            !empty($row[$this->indexes[DbMap::EMAIL]]) ||
                            !empty($row[$this->indexes[DbMap::COMPANY_CODE]])   // This condition is for company table only
                        )
                    ){
                        $allRowsIgnored = false;

                        // 对于 Regional territory report 来讲, 有一些特殊处理: 55开头的 dealer code 都是无效的; dealer code 141 是无效的
                        if($tableName == RegionTerritoryReport::TABLE_NAME
                            && (
                                strpos($row[$this->indexes['dealer_code']],RegionTerritoryReport::PREFIX_OF_USELESS_DEALER_CODE)===0 ||
                                $row[$this->indexes['dealer_code']] === RegionTerritoryReport::USELESS_DEALER_CODE
                            )){
                            continue;
                        }

                        $whereCondition = $this->_getWhereCondition($tableName, $row);
                        $resultSet = $db->select($tableName,'*',$whereCondition);
                        $found = count($resultSet) > 0;

//                        if(!$found){
//                            $model = $this->_getANewModel($roleAbbr, $user, $tableName);
//                        }
                        $model = $this->_getANewModel($roleAbbr, $user, $tableName);
                        if($found){

                            $this->_lastFoundResultSet = $resultSet[0];


                            if ($index === 1) {                                
                                $cCH = [];
                                foreach ($csvColHeaders as $key) {
                                    $cCH[] = preg_replace('/_$/', '', strtolower($key));
                                }

                                $dumpedCsvFields = array_diff($cCH, array_keys($map)); 
                                $dbFieldsNotSet = array_diff(array_keys($this->_lastFoundResultSet), array_values($map));
                                $dbFieldsNotSet = array_diff($dbFieldsNotSet, [$model->getIdFieldName()]);
                            }                            

                            foreach ($this->_lastFoundResultSet as $currentFieldName => $fieldValue) {
                                if(is_string($currentFieldName)){
                                    if($isSyncAction){
                                        // 数据同步的操作
                                        if($currentFieldName == $model->getIdFieldName()){
//                                            $idField = $model->getIdFieldName();
                                            $model->$currentFieldName = $fieldValue;

                                        }elseif($currentFieldName == 'period'){
                                            $periodConverted  = CsvTool::ConvertDateToYmd($row[$this->indexes[$currentFieldName]]);
                                            $model->period = $periodConverted;

                                        }elseif(isset($this->indexes[$currentFieldName])){
                                            $newValue =
                                                empty($row[$this->indexes[$currentFieldName]]) ?
                                                    null :                                         // If csv value is empty, then use the 0
                                                    $row[$this->indexes[$currentFieldName]];    // If csv value is not empty, save it
                                            $newValue = $this->_stringValueToInteger($newValue);
                                            $model->$currentFieldName = trim($newValue);
                                        }
                                    }
                                    else{
                                        $val = $row[$this->indexes[$currentFieldName]];
                                        if ( in_array($currentFieldName, $date_type_fields)) {                             
                                            if($val && !preg_match('/^\d{7,8}$/', $val)) {
                                                print "Bad date line(". ($index+2) . ") $currentFieldName: '<em>". nl2br($val) ."</em>'";
                                                exit;
                                            }
                                         }


                                        if($currentFieldName == $model->getIdFieldName()){
                                            $this->resultArray[$index][$model->getIdFieldName()] = $fieldValue;
                                        }elseif($currentFieldName == 'period'){
                                            $tmp = CsvTool::ConvertDateToYmd($row[$this->indexes[$currentFieldName]]);
                                            $equal = $fieldValue == $tmp;
                                            $this->resultArray[$index]['period'] = $fieldValue.' / <span style="color:'.($equal?'blue':'red').';">'.$row[$this->indexes[$currentFieldName]].'</span>';
                                        




                                        }elseif(isset($this->indexes[$currentFieldName])){
                                            // Not ID, need compare
                                            $equal = trim($row[$this->indexes[$currentFieldName]]) == $fieldValue || empty($row[$this->indexes[$currentFieldName]]);
                                            $this->resultArray[$index][$currentFieldName] = $fieldValue.' / <span style="color:'.($equal?'blue':'red').';">'.$row[$this->indexes[$currentFieldName]].'</span>';
                                        }
                                    }
                                }
                            }

                        }
                        else{
                            // Trying to create a new record
                            if($isSyncAction){
                                if($this->_lastFoundResultSet){
                                    foreach ($this->_lastFoundResultSet as $currentFieldName => $fieldValue) {
                                        if(is_string($currentFieldName)){

                                            if($currentFieldName == $model->getIdFieldName()){
                                                // 为了新增操作
                                                $idField = $model->getIdFieldName();
                                                $model->$idField = null;
                                            }elseif($currentFieldName == 'period'){
                                                $periodConverted  = CsvTool::ConvertDateToYmd($row[$this->indexes[$currentFieldName]]);
                                                $model->period = $periodConverted;


                                            }elseif(isset($this->indexes[$currentFieldName])){
                                                $newValue =
                                                    empty($row[$this->indexes[$currentFieldName]]) ?
                                                        0 :                                         // If csv value is empty, then use the 0
                                                        $row[$this->indexes[$currentFieldName]];    // If csv value is not empty, save it
                                                $newValue = $this->_stringValueToInteger($newValue);
                                                $model->$currentFieldName = trim($newValue);
                                            }
                                        }
                                    }
                                }
                                else{
                                    foreach ($this->indexes as $fieldName=>$rowIndex) {

                                        if($fieldName == 'period'){
                                            $periodConverted  = CsvTool::ConvertDateToYmd($row[$rowIndex]);
                                            $model->period = $periodConverted;
                                        }else{
                                            $newValue =
                                                empty($row[$rowIndex]) ?
                                                    0 :                                         // If csv value is empty, then use the 0
                                                    $row[$rowIndex];    // If csv value is not empty, save it
                                            $newValue = $this->_stringValueToInteger($newValue);
                                            $model->$fieldName = trim($newValue);
                                        }
                                    }

                                }
                            }else{
                                $this->notFoundArray[$index] = $row;
                            }
                        }
                        if($isSyncAction){
                            // If users' data is uploading
                            if($tableName === User::TABLE_NAME){
                                // Handle the password field
                                if($found){
                                    // Todo: keep the old password if it's existed; General one if it's not existed yet
                                    if(empty($found['password'])){
                                        $model->password = strtoupper($this->_lastFoundResultSet['lastname']).'1';
                                    }
                                }else{
                                    // Not found, means a new user account
                                    $model->password = strtoupper($row[$this->indexes['lastname']]).'1';
                                }
                            }

                            // if region staff
                            if($roleAbbr === User::REGION_STAFF){
                                $model->company_id = 8;
                            }

                            $model->save();
                            $syncedRowsCount++;
                        }
                    }
                    else{

                    }
                }

                if ($allRowsIgnored) {
                    print "Couldn't find any of these fields <br>";
                    print DbMap::MEMBER_ID ."<br>";
                    print DbMap::EMPLOYEE_CODE ."<br>";
                    print DbMap::EMAIL ."<br>";
                    print DbMap::COMPANY_CODE ."<br>";

                    print "<pre>";
                    print_r($map);

                    print_r($this->indexes);
                    print "tableName = $tableName\n";
                    exit;                    
                }

                if($isSyncAction){
                    echo $this->allHtml."Synced: $syncedRowsCount rows.";
                }else{
                    $this->_printResultArray( '<h1>'.$tableName.'</h1>');
                    print "\n<pre>\n";
                    if ($dumpedCsvFields) {
                        print "Fields from the CSV not mapped to anything\n";
                        $out = print_r($dumpedCsvFields,1);
                        foreach(explode("\n", $out) as $line) {
                            if (preg_match('/\[(\d\d?)\](.*)/', $line, $matches)) {
                                $letter = ($matches[1] > 26 ? 'A':'') . (chr( 65 + $matches[1] % 26)); 
                                print "  col($letter) $matches[2]\n";
                            }
                        }
                    }
                    if ($dbFieldsNotSet) {
                        print "\nFields in the database not set by the import\n";
                        print_r($dbFieldsNotSet);
                    }

                }
            }
        }
    }

    private function _stringValueToInteger($stringValue)
    {
        $map = [
            'NO'  => 0,
            'YES' => 1,
            'NA'  => 2  // a special case pam asked for, for sales manager
        ];
        $stringValue2 = trim(strtoupper($stringValue));
        if( isset($map[$stringValue2])){
            return $map[$stringValue2];
        }
        return $stringValue;
    }

    /**
     * Get the right where conditions for different table
     * @param $tableName
     * @param $row
     * @return array
     */
    private function _getWhereCondition($tableName, $row){
        $where = [
            'AND'=>[]
        ];
        if(in_array(DbMap::DEALER_CODE, array_keys($this->indexes)) && !is_null($row[$this->indexes[DbMap::DEALER_CODE]])){
            $where['AND'][DbMap::DEALER_CODE] = $row[$this->indexes[DbMap::DEALER_CODE]];
        }
        if(in_array(DbMap::MEMBER_ID, array_keys($this->indexes)) && !is_null($row[$this->indexes[DbMap::MEMBER_ID]])){
            $where['AND'][DbMap::MEMBER_ID] = $row[$this->indexes[DbMap::MEMBER_ID]];
        }
        if(in_array(DbMap::PERIOD, array_keys($this->indexes)) && !is_null($row[$this->indexes[DbMap::PERIOD]])){
            $where['AND'][DbMap::PERIOD] = CsvTool::ConvertDateToYmd($row[$this->indexes[DbMap::PERIOD]]);
        }

        /**
         * Handle special tables
         */
        if($tableName === RegionTerritoryReport::TABLE_NAME){
            $where = [
                'AND'=>[
                    DbMap::EMPLOYEE_CODE=> $row[$this->indexes[DbMap::EMPLOYEE_CODE]],
                    DbMap::PERIOD  => configuration('YEAR'),
                ]
            ];
        }

        /**
         * This is for the company table ONLY
         */
        if($tableName === Company::TABLE_NAME){
            $where = [
                DbMap::COMPANY_CODE=>$row[$this->indexes[DbMap::COMPANY_CODE]]
            ];
        }

        /**
         * This is for the users table ONLY
         */
        if($tableName === User::TABLE_NAME){
            if(isset($row[$this->indexes[DbMap::EMPLOYEE_CODE]]) && !empty($row[$this->indexes[DbMap::EMPLOYEE_CODE]])){
                $where = [
                    DbMap::EMPLOYEE_CODE=>$row[$this->indexes[DbMap::EMPLOYEE_CODE]]
                ];
            }else{
                $where = [
                    DbMap::EMAIL=>$row[$this->indexes[DbMap::EMAIL]]
                ];
            }
        }
        return $where;
    }

    /**
     * Concat single table HTML
     * @param $tableName
     */
    private function _printResultArray($tableName){
        $html = $tableName.'<table border="1"><tbody>';
        foreach ($this->resultArray as $key => $tr) {
            if(empty($this->resultTableHead)){
                $keys = array_keys($tr);
                foreach ($keys as $theKey) {
                    $this->resultTableHead .= '<td>'.$this->fieldMap[$theKey].'</td>';
                }
                $html .= '<tr>'.$this->resultTableHead.'</tr>';
            }
            $html .= '<tr>';
            foreach ($tr as $fieldName => $text) {
                $html .= '<td>'.$text.'</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        if(!empty($this->notFoundArray)){
            $html .= $this->_getNotFoundTableHtml();
        }
        $this->allHtml .= $html;
        echo $this->allHtml;
    }

    /**
     * Generate the table html for rows that not found from database
     * @return string
     */
    private function _getNotFoundTableHtml(){
        $html = '<br><h2>CSV rows not matched</h2><table border="1"><tbody><tr><th>Line #</th>';
        $head = '';
        $content = '';
        $index = 0;

        foreach ($this->notFoundArray as $csvFileLineNumber=>$rowData) {
            if($index === 0){
                $index++;
                for ($idx = 0; $idx < count($rowData); $idx++){
                    $head .= '<th></th>';
                }
                $head .= '</tr>';
            }
            $content .= '<tr><td>'.$csvFileLineNumber.'</td>';
            foreach ($rowData as $item) {
                $content .= '<td>'.$item.'</td>';
            }
            $content .= '</tr>';
        }
        return $html . $head . $content . '</tbody></table>';
    }

    /**
     * Setup db fieldName=> csv row index value. Return true if find the matched map array
     * @param $csvRowArray
     * @param $tableName
     * @return bool
     */
    private function _matchDbFields($csvRowArray, $tableName, $roleAbbr, $getMap=false){
        $findMatch = true;

        switch ($tableName){
            case 'nissan_servicemanagers':
                $map = DbMap::ServiceManagerTable();
                break;
            case 'nissan_partsrep':
                $map = DbMap::PartsRepTable();
                break;
            case 'nissan_salesmanagers':
                $map = DbMap::SalesManagerTable();
                break;
            case 'nissan_salesconsultants':
                $map = DbMap::RetailSalesConsultantTable();
                break;
            case 'nissan_fleetsalesexecutives':
                $map = DbMap::FleetSalesExecutivesTable();
                break;
            case 'nissan_fi':
                $map = DbMap::FiAdministrationTable();
                break;
            case 'nissan_financialcontrollers':
                $map = DbMap::FinanceControllerTable();
                break;
            case 'nissan_partsmanager':
                $map = DbMap::PartsManagerTable();
                break;
            case 'nissan_stockcontroller':
                $map = DbMap::StockControllerTable();
                break;
            case 'nissan_serviceadvisors':
                $map = DbMap::ServiceAdvisorsTable();
                break;
            case RegionTerritoryReport::TABLE_NAME:
                $map = DbMap::RegionTerritoryReportTable();
                break;
            case Credit::TABLE_NAME:
                $map = DbMap::NissanCreditsTable();
                break;
            case Ranking::TABLE_NAME:
                $map = DbMap::NissanRankingsTable();
                break;
            case Company::TABLE_NAME:
                $map = DbMap::NissanDealersTable();
                break;
            case User::TABLE_NAME:
                $map = DbMap::UserTable();
                break;
            default:
                $findMatch = false;
                break;
        }

        if($roleAbbr === User::REGION_STAFF){
            $map = DbMap::RegionStaffTable();
        }
        $this->fieldMap = $map;
        $map = array_flip($map);

        if ($getMap) return $map;
        foreach ($csvRowArray as $index => $rowName) {
            $rowName2 = preg_replace('/_$/', '', strtolower($rowName)); // replace _ at the end and change to lower case 

            if(isset($map[$rowName2])){
                $this->indexes[$map[$rowName2]] = $index;
            }
        }

        return $findMatch;
    }

    public function fix_users_password(){
        // Get all Nissan dealer's users
        $db = User::DB();
        $users = $db->select('users',['employee_code','parent_id'],[
            'AND'=>[
                'parent_id'=>8,
                'employee_code[!]'=>null
            ]
        ]);
        $count = 0;
        foreach ($users as $user) {
            $ou = $db->select('users_copy',['password','employee_code'],['employee_code'=>$user['employee_code']]);
            if($ou && count($ou) > 0){
                $db->update('users',['password'=>$ou[0]['password']],['employee_code'=>$user['employee_code']]);
                $count++;
            }
        }
        dump($count);
    }

    /**
     * Usage Log - this is a route
     * @param none
     * @return null
     */
    public function usage() {
        $submit = $this->request->param('submit');

        $datestart =    $this->dataForView['datestart']    = $this->request->param('datestart');
        $dateend =      $this->dataForView['dateend']      = $this->request->param('dateend');
        $user_selected =$this->dataForView['user_selected']= $this->request->param('user_selected');
        $page_selected =$this->dataForView['page_selected']= $this->request->param('page_selected');
        $summarise_by = $this->dataForView['summarise_by'] = $this->request->param('summarise_by');

        $usage = file_get_contents('../app/storage/log/usage_log');
        $usage_lines = explode("\n", $usage);

        $db = User::DB();

        $pages = [];

        $excludes = [
            '/^\/$/',
            '/^\/css/',
            '/\.js$/',
            '/^\/admin/',
            '/^\/api/',
            '/^\/user\/logout/',
            '/^\/files/'
        ];

        $pages_data= '';

        // this pass get all pages
        foreach ($usage_lines as $line) {
            if (preg_match('/^(.*)\?/', $line, $matches)) {  // strip off ?query part of url
                $line = $matches[1];
            }

            if (preg_match('/^([^\s]*)\s(\{[^\{]*\})\s([^\s]*)$/', $line, $matches)) {
                list($all, $time, $user, $page) = $matches;

                foreach ($excludes as $ex) {
                    if (preg_match($ex, $page)) continue 2;
                }

                $json = json_decode($user);                
                if (!in_array($page, $pages)) $pages[] = $page;
                if (!in_array($json->id, $user_ids)) $user_ids[] = $json->id;
            }
        }
        sort($pages);

        $users = $db->query( $q = "
            SELECT 
                users.user_id,
                lastname, 
                firstname,
                CASE 
                    WHEN company.region='N' THEN 'Northern Region'
                    WHEN company.region='E' THEN 'Eastern Region'
                    WHEN company.region='W' THEN 'Western and Central Region'
                    WHEN company.region='S' THEN 'Southern Region'
                    ELSE '(Head Office)'
                END as region,                
                company.company_name,
                company.company_id,
                CASE
                    WHEN users.position='PM'  then 'Parts Manager'
                    WHEN users.position='SM'  then 'Service Manager'
                    WHEN users.position='SA'  then 'Service Advisor'
                    WHEN users.position='R'   then 'Retail Sales Consultant'
                    WHEN users.position='M'   then 'Sales Manager'
                    WHEN users.position='F'   then 'Fleet Sales Manager'
                    WHEN users.position='I'   then 'Finance & Insurance Manager'
                    WHEN users.position='SC'  then 'Stock Controller'
                    WHEN users.position='PS'  then 'Parts Sales Rep'
                    WHEN users.position='C'   then 'Finance Controller'
                    WHEN users.position='NFSA' then 'Head Office'
                    WHEN users.position='DSM' then 'Region Staff'
                    WHEN users.position='RGM' then 'Region Staff'
                    WHEN users.position='ROA' then 'Region Staff'
                    WHEN users.position='FOM' then 'Region Staff'
                    WHEN users.position='FDM' then 'Region Staff'
                    WHEN users.position='DSM' then 'Region Staff'
                    WHEN users.position='DTS' then 'Region Staff'
                    WHEN users.position='RAM' then 'Region Staff'
                    WHEN users.position='HEAD OFFICE' then 'Head Office'
                    else users.position
                END as position,
                CASE
                    WHEN users.position='PM'  then 'Parts'
                    WHEN users.position='SM'  then 'Service'
                    WHEN users.position='SA'  then 'Service'
                    WHEN users.position='R'   then 'Sales'
                    WHEN users.position='M'   then 'Sales'
                    WHEN users.position='F'   then 'Sales'
                    WHEN users.position='I'   then 'Admin'
                    WHEN users.position='SC'  then 'Admin'
                    WHEN users.position='PS'  then 'Parts'
                    WHEN users.position='C'   then 'Admin'
                    WHEN users.position='NFSA' then 'Nissan AU'
                    WHEN users.position='DSM' then 'Nissan AU'
                    WHEN users.position='RGM' then 'Nissan AU'
                    WHEN users.position='ROA' then 'Nissan AU'
                    WHEN users.position='FOM' then 'Nissan AU'
                    WHEN users.position='FDM' then 'Nissan AU'
                    WHEN users.position='DSM' then 'Nissan AU'
                    WHEN users.position='DTS' then 'Nissan AU'
                    WHEN users.position='RAM' then 'Nissan AU'
                    WHEN users.position='HEAD OFFICE' then 'Nissan AU'
                    else users.position
                END as department
            FROM 
                users
            JOIN 
                company ON users.company_id=company.company_id
            where user_id in (". implode(',',$user_ids) .")
            ORDER BY 
                company.region, company.company_name, firstname, lastname     
        ")->fetchAll();

        $users_by_id = [];
        foreach ($users  as $u) {
            $users_by_id[$u['user_id']] = $u;
        }

        $pages_data= [];

        foreach ($usage_lines as $line) {

            if (preg_match('/^(.*)\?/', $line, $matches)) {
                $line = $matches[1];
            }

            if (preg_match('/^([^\s]*)\s(\{[^\{]*\})\s([^\s]*)$/', $line, $matches)) {

                list($all, $time, $user, $page) = $matches;

                if ($page == '/') continue 1;

                foreach ($excludes as $ex) {
                    if (preg_match($ex, $page)) continue 2;
                }

                $json = json_decode($user);                

                if ($user_selected > 0) {  // filter by user
                    if ($json->id != $user_selected) continue;

                } elseif (preg_match('/All company (\d*)$/', $user_selected, $matches)) {
                    if ($users_by_id[$json->id]['company_id'] != $matches[1]) continue;

                } elseif (preg_match('/All for (.*)$/', $user_selected, $matches)) {  // filter by region
                    if ($users_by_id[$json->id]['region'] != $matches[1]) continue;
                }

                if ($page_selected && $page_selected != $page) continue;  // filter by page

                if ($datestart && strtotime($datestart) > $time) continue;
                if ($dateend   && strtotime($dateend)+86400 < $time) continue;   // add a day for inclusive date range 

                if (!in_array($page, $pages)) $pages[] = $page;                 // for pages selector
                if (!in_array($json->id, $user_ids)) $user_ids[] = $json->id;   // for list of users selector

                $region = $users_by_id[$json->id]['region'];
                $dealership = $users_by_id[$json->id]['company_name'];
                $position = $users_by_id[$json->id]['position'];
                $department = $users_by_id[$json->id]['department'];

                if ($summarise_by == 'Region')     $key = "$region|$page";
                if ($summarise_by == 'Dealership') $key = "$region|$dealership|$page";
                if ($summarise_by == 'Position')   $key = "$position|$department|$page";
                if ($summarise_by) {
                    if (!isset($pages_data[$key])) {
                        $pages_data[$key] = 1;
                    } else {
                        $pages_data[$key]++;
                    }
                } else {
                    $report[] = [
                        $region,
                        $dealership,
                        $users_by_id[$json->id]['firstname'].' '.$users_by_id[$json->id]['lastname'],
                        $department,
                        $position,
                        Carbon::createFromTimestamp($time,'Australia/Melbourne')->format('d-m-y H:i'),
                        $page
                    ];
                }
            }
        }

        if ($this->request->param('summarise_by')) {
            ksort($pages_data);
            $report = [];
            foreach ($pages_data as $key=>$p) {
                $arr = explode('|', $key);
                
                $row = [];
                $row[] = $arr[0];
                $row[] = $arr[1];
                if ($summarise_by == 'Dealership' || $summarise_by == 'Position') $row[] = $arr[2];
                $row[] = $p;                
                $report[] = $row;
            }
        }      

        $headings = [];

        if ($summarise_by != 'Position')                                  $headings[] = 'Region';
        if ($summarise_by != 'Region' and $summarise_by != 'Position' )   $headings[] = 'Dealership';
        if ($summarise_by == '')                                          $headings[] = 'Name';
        if ($summarise_by != 'Dealership' and $summarise_by != 'Region' ) $headings[] = 'Department';
        if ($summarise_by != 'Dealership' and $summarise_by != 'Region' ) $headings[] = 'Position';
        if ($summarise_by == '')                                          $headings[] = 'Time';
                                                                          $headings[] = 'Page';
        if ($summarise_by != '')                                          $headings[] = 'Count';

        if ($submit == 'Export') {
            $today = Carbon::today(env('DEFAULT_TIMEZONE'));
            $filePath = env('APP_PATH').'storage'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'nissan_admin_'.$today->format('d_M_Y').'.csv';
            $fileStream = fopen($filePath,'w');

            $writer = Writer::createFromStream($fileStream);

            $writer->insertOne(implode(',',$headings));
            $writer->insertAll($report);

            fclose($fileStream);

            $this->response->file($filePath,null,'csv');
            return;
        } else {
            $this->dataForView['report_headings'] = $headings;
            $this->dataForView['report'] = $report;
            $this->dataForView['users'] = $users;
            $this->dataForView['user_selected'] = $user_selected;
            $this->dataForView['pages'] = $pages; //a list of all pages

            $this->render('backend/users/usage');
            return;
        }
    }
}
