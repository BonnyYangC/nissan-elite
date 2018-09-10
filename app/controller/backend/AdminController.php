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
use App\models\management\ManagerRegion;
use App\models\management\RegionTerritoryReport;
use App\models\nissan\Credit;
use App\models\nissan\DataSource;
use App\models\nissan\Ranking;
use App\models\User;
use App\models\utils\RoleFactory;
use Klein\Request;
use Klein\Response;
use App\models\utils\TableFieldMap as DbMap;

class AdminController extends BaseController
{
    /**
     * @var array
     */
    private $indexes = [];
    private $csvFileIndexes = null; // The first row of the csv file, as the index
    private $resultArray = [];
    private $notFoundArray = [];

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

    private $allHtml = '<a href="/admin-panel">Go Back</a><br>';

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Update system env file
     */
    public function update_env(){
        /**
         * @var array $env
         */
        $env = $this->request->param('env');
        $content = 'APP_NAME="'.$env['APP_NAME'].'"'.PHP_EOL;
        $content .= 'DEV_MODE='.( $env['DEV_MODE']=='1' ? 'false' : 'true').PHP_EOL;
        $content .= 'SALT=L=kGL*y^Cv3YYs5Lq2k_wZQxtjS5_Y$LFaJJ%MdC+#NpbAZ#PaZtNJ2!HmffXTsc'.PHP_EOL;
        $content .= 'SITE_URL='.$env['SITE_URL'].PHP_EOL;
        $content .= 'ROOT_PATH="'.$env['ROOT_PATH'].'"'.PHP_EOL;
        $content .= 'APP_PATH="${ROOT_PATH}/app/"'.PHP_EOL;
        $content .= 'VIEW_PATH="${ROOT_PATH}/app/views/"'.PHP_EOL;
        $content .= 'PUBLIC_UPLOADS_PATH_ROOT="${APP_PATH}storage/public/uploads"'.PHP_EOL;
        $content .= 'SESSION_SEGMENT=_nissanac'.PHP_EOL;
        $content .= 'YEAR='.$env['YEAR'].PHP_EOL;
        $content .= 'DEFAULT_TIMEZONE="Australia/Melbourne"'.PHP_EOL;
        $content .= 'dealExcellenceOverviewUrl=http://nissan-events.com.au/excellence-fy17/ac/welcome.html'.PHP_EOL;
        $content .= 'eventRegisterUrl="http://www.nissan-events.com.au/ac${YEAR}/reg"'.PHP_EOL;
        $content .= 'DB_DRIVER=mysql'.PHP_EOL;
        $content .= 'DB_USER='.$env['DB_USER'].PHP_EOL;
        $content .= 'DB_PASSWORD='.$env['DB_PASSWORD'].PHP_EOL;
        $content .= 'DB_NAME='.$env['DB_NAME'].PHP_EOL;
        $content .= 'DB_HOST=localhost'.PHP_EOL;
        $content .= 'PAGE_SIZE='.$env['PAGE_SIZE'].PHP_EOL;
        $content .= 'ADMIN_USER='.$env['ADMIN_USER'].PHP_EOL;
        $content .= 'ADMIN_PASSWORD='.$env['ADMIN_PASSWORD'].PHP_EOL;
        $content .= 'MAIL_SENDGRID_API_KEY='.$env['MAIL_SENDGRID_API_KEY'].PHP_EOL;
        $content .= 'SUPPORT_EMAIL_ADDRESS='.$env['SUPPORT_EMAIL_ADDRESS'].PHP_EOL;
        $content .= 'SUPPORT_EMAIL_NAME="'.$env['SUPPORT_EMAIL_NAME'].'"'.PHP_EOL;
        $content .= 'MOBILE_VERSION="'.$env['MOBILE_VERSION'].'"'.PHP_EOL;

        file_put_contents(env('APP_PATH').'/helpers/.env',$content);

        $this->response->redirect('/admin-panel');
    }

    /**
     * Load panel
     */
    public function index(){
        $this->dataForView['roles'] = DataSource::$_rolesMap;
        $this->dataForView['summary'] = [
            Credit::TABLE_NAME=>'Nissan Credits',
            Ranking::TABLE_NAME=>'Nissan Rankings',
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
        $userId = $this->request->param('uid');
        $user = new User($userId);

        $uuid = random_str(uniqid());
        $this->response->cookie('uuid',$uuid,time() + 3600,'/',url());

        session_set(env('SESSION_SEGMENT','_nissanac_fake'), $uuid);
        session_set('user_data_array', [
            'id'=>$user->getId(),
            'name'=>$user->getName()
        ]);
        session_set('selected_role',null);

        // redirect to this user's dashboard
        return $this->response->redirect('/dashboard')->send();
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
     * Cross check or sync database with submitted csv file
     */
    public function csv_importer(){
        $isSyncAction = $this->request->param('action_type') == 'sync';

        $uploader = new FileUploader($this->request);
        $filePath = $uploader->store('csv');
        $syncedRowsCount = 0;

        if($filePath){
            /**
             * @var File $file
             */
            if (file_exists($filePath)) {
                $user = new User();
                $roleAbbr = $this->request->param('for');
                $tableName = DataSource::nissan_get_table_name_from_abbr($roleAbbr);
                $model = $this->_getANewModel($roleAbbr, $user, $tableName);

                // Call any method on an SplFileInfo instance
                $reader = CsvTool::ReadFile($filePath);

                foreach ($reader as $index=>$row) {
                    if($index === 0){
                        $this->csvFileIndexes = $row;
                        $this->_matchDbFields($row, $tableName, $roleAbbr);
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
                            !empty($row[$this->indexes[DbMap::EMPLOYEE_CODE]]) ||
                            !empty($row[$this->indexes[DbMap::EMAIL]]) ||
                            !empty($row[$this->indexes[DbMap::COMPANY_CODE]])   // This condition is for company table only
                        )
                    ){
                        $whereCondition = $this->_getWhereCondition($tableName, $row);

                        $resultSet = $db->select($tableName,'*',$whereCondition);
                        $found = count($resultSet) > 0;

                        if(!$found){
                            $model = $this->_getANewModel($roleAbbr, $user, $tableName);
                        }

                        if($found){
                            $this->_lastFoundResultSet = $resultSet[0];
                            foreach ($this->_lastFoundResultSet as $currentFieldName => $fieldValue) {
                                if(is_string($currentFieldName)){
                                    if($isSyncAction){
                                        // 数据同步的操作
                                        if($currentFieldName == $model->getIdFieldName()){
                                            $idField = $model->getIdFieldName();
                                            $model->$idField = $fieldValue;
                                        }elseif($currentFieldName == 'period'){
                                            $periodConverted  = CsvTool::ConvertDateToYmd($row[$this->indexes[$currentFieldName]]);
                                            $model->period = $periodConverted;
                                        }elseif(isset($this->indexes[$currentFieldName])){
                                            $newValue =
                                                empty($row[$this->indexes[$currentFieldName]]) ?
                                                    null :                                         // If csv value is empty, then use the 0
                                                    $row[$this->indexes[$currentFieldName]];    // If csv value is not empty, save it
                                            if(strtoupper($newValue) == 'YES'){
                                                $newValue = 1;
                                            }elseif (strtoupper($newValue) == 'NO'){
                                                $newValue = 0;
                                            }
                                            $model->$currentFieldName = trim($newValue);
                                        }
                                    }else{
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
                                                if(strtoupper($newValue) == 'YES'){
                                                    $newValue = 1;
                                                }elseif (strtoupper($newValue) == 'NO'){
                                                    $newValue = 0;
                                                }
                                                $model->$currentFieldName = trim($newValue);
                                            }
                                        }
                                    }
                                }else{
                                    foreach ($this->indexes as $fieldName=>$rowIndex) {
                                        if($fieldName == 'period'){
                                            $periodConverted  = CsvTool::ConvertDateToYmd($row[$rowIndex]);
                                            $model->period = $periodConverted;
                                        }else{
                                            $newValue =
                                                empty($row[$rowIndex]) ?
                                                    0 :                                         // If csv value is empty, then use the 0
                                                    $row[$rowIndex];    // If csv value is not empty, save it
                                            if(strtoupper($newValue) == 'YES'){
                                                $newValue = 1;
                                            }elseif (strtoupper($newValue) == 'NO'){
                                                $newValue = 0;
                                            }
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
                }

                if($isSyncAction){
                    echo $this->allHtml."Synced: $syncedRowsCount rows.";
                }else{
                    $this->_printResultArray( '<h1>'.$tableName.'</h1>');
                }
            }
        }
    }

    /**
     * Get the right where conditions for different table
     * @param $tableName
     * @param $row
     * @return array
     */
    private function _getWhereCondition($tableName, $row){
        $where = [
            'AND'=>[
                DbMap::MEMBER_ID    => $row[$this->indexes[DbMap::MEMBER_ID]],
                DbMap::DEALER_CODE  => $row[$this->indexes[DbMap::DEALER_CODE]],
                DbMap::PERIOD       => CsvTool::ConvertDateToYmd($row[$this->indexes[DbMap::PERIOD]]),
            ]
        ];

        if($tableName === RegionTerritoryReport::TABLE_NAME){
            $where = [
                'AND'=>[
                    DbMap::EMPLOYEE_CODE=> $row[$this->indexes[DbMap::EMPLOYEE_CODE]],
                    DbMap::PERIOD  => env('YEAR'),
                ]
            ];
        }

        if(!is_null($row[$this->indexes[DbMap::DEALER_CODE]])){
            $where['AND'][DbMap::DEALER_CODE] = $row[$this->indexes[DbMap::DEALER_CODE]];
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
            if(isset($row[$this->indexes[DbMap::EMAIL]]) && !empty($row[$this->indexes[DbMap::EMAIL]])){
                $where = [
                    DbMap::EMAIL=>$row[$this->indexes[DbMap::EMAIL]]
                ];
            }else{
                $where = [
                    DbMap::EMPLOYEE_CODE=>$row[$this->indexes[DbMap::EMPLOYEE_CODE]]
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
                    $this->resultTableHead .= '<td>'.$theKey.'</td>';
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
    private function _matchDbFields($csvRowArray, $tableName, $roleAbbr){
        $findMatch = true;

        switch ($tableName){
            case 'nissan_servicemanagers':
                $map = DbMap::ServiceManagerTable();
                break;
            case 'nissan_partsrep':
                $map = DbMap::PartnerRepresentativeTable();
                break;
            case 'nissan_salesmanagers':
                $map = DbMap::SalesManagerTable();
                break;
            case 'nissan_salesconsultants':
                $map = DbMap::ConsultantSalesTable();
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

        $map = array_flip($map);

        foreach ($csvRowArray as $index => $rowName) {
            if(isset($map[$rowName])){
                $this->indexes[$map[$rowName]] = $index;
            }
        }

        return $findMatch;
    }
}