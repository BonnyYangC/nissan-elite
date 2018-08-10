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
use App\models\nissan\DataSource;
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
    private $resultArray = [];
    private $notFoundArray = [];

    /**
     * Result table had td tags only
     * @var string
     */
    private $resultTableHead = '';

    private $allHtml = '';

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

        $content = 'DEV_MODE='.( $env['DEV_MODE']=='1' ? 'false' : 'true').PHP_EOL;
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
        $content .= 'ADMIN_USER='.$env['ADMIN_USER'].PHP_EOL;
        $content .= 'ADMIN_PASSWORD='.$env['ADMIN_PASSWORD'].PHP_EOL;
        $content .= 'MAIL_SENDGRID_API_KEY='.$env['MAIL_SENDGRID_API_KEY'].PHP_EOL;
        $content .= 'SUPPORT_EMAIL_ADDRESS='.$env['SUPPORT_EMAIL_ADDRESS'].PHP_EOL;
        $content .= 'SUPPORT_EMAIL_NAME="'.$env['SUPPORT_EMAIL_NAME'].'"'.PHP_EOL;

        file_put_contents(env('APP_PATH').'/helpers/.env',$content);

        $this->response->redirect('/admin-panel');
    }

    /**
     * Load panel
     */
    public function index(){
        $this->dataForView['roles'] = DataSource::$_rolesMap;
        $this->render('backend/index');
        return;
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
                $model = RoleFactory::GetModel($roleAbbr ,$user);
                $tableName = DataSource::nissan_get_table_name_from_abbr($roleAbbr);
                $model->setTableName($tableName);

                // Call any method on an SplFileInfo instance
                $reader = CsvTool::ReadFile($filePath);
                foreach ($reader as $index=>$row) {
                    if($index === 0){
                        $this->_matchDbFields($row, $tableName);
                    }
                }
                /**
                 * Get database connection
                 */
                $db = BaseModel::DB();


                foreach ($reader as $index=>$row) {
                    if($index > 0 && !empty($row[$this->indexes[DbMap::MEMBER_ID]])){
                        $resultSet = $db->select($tableName,'*',[
                            'AND'=>[
                                DbMap::MEMBER_ID    => $row[$this->indexes[DbMap::MEMBER_ID]],
                                DbMap::DEALER_CODE  => $row[$this->indexes[DbMap::DEALER_CODE]],
                                DbMap::PERIOD       => CsvTool::ConvertDateToYmd($row[$this->indexes[DbMap::PERIOD]]),
                            ]
                        ]);

                        if(count($resultSet) === 1){
                            foreach ($resultSet[0] as $currentFieldName => $fieldValue) {
                                if(is_string($currentFieldName)){
                                    if($isSyncAction){
                                        // 数据同步的操作
                                        if($currentFieldName == 'id'){
                                            $model->id = $fieldValue;
//                                            $model->find($fieldValue);
                                        }elseif($currentFieldName == 'period'){
                                            $periodConverted  = CsvTool::ConvertDateToYmd($row[$this->indexes[$currentFieldName]]);
                                            $model->period = $periodConverted;
                                        }elseif(isset($this->indexes[$currentFieldName])){
                                            $newValue =
                                                empty($row[$this->indexes[$currentFieldName]]) ?
                                                    $fieldValue :                   // If csv value is empty, then use the original
                                                    $row[$this->indexes[$currentFieldName]];    // If csv value is not empty, save it
                                            if(strtoupper($newValue) == 'YES'){
                                                $newValue = 1;
                                            }elseif (strtoupper($newValue) == 'NO'){
                                                $newValue = 0;
                                            }
                                            $model->$currentFieldName = $newValue;
                                        }
                                    }else{
                                        if($currentFieldName == 'id'){
                                            $this->resultArray[$index]['id'] = $fieldValue;
                                        }elseif($currentFieldName == 'period'){
                                            $tmp = CsvTool::ConvertDateToYmd($row[$this->indexes[$currentFieldName]]);
                                            $equal = $fieldValue == $tmp;
                                            $this->resultArray[$index]['period'] = $fieldValue.' / <span style="color:'.($equal?'blue':'red').';">'.$row[$this->indexes[$currentFieldName]].'</span>';
                                        }elseif(isset($this->indexes[$currentFieldName])){
                                            // Not ID, need compare
                                            $equal = $row[$this->indexes[$currentFieldName]] == $fieldValue || empty($row[$this->indexes[$currentFieldName]]);
                                            $this->resultArray[$index][$currentFieldName] = $fieldValue.' / <span style="color:'.($equal?'blue':'red').';">'.$row[$this->indexes[$currentFieldName]].'</span>';
                                        }
                                    }
                                }
                            }
                            if($isSyncAction){
                                $model->save();
                                $syncedRowsCount++;
                            }
                        }else{
                            $this->notFoundArray[$index] = $row;
                        }
                    }
                }

                if($isSyncAction){
                    echo "Synced: $syncedRowsCount rows.";
                }else{
                    $this->_printResultArray( '<h1>'.$tableName.'</h1>');
                }
            }
        }
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
    private function _matchDbFields($csvRowArray, $tableName){
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
            default:
                $findMatch = false;
                break;
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