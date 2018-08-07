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
use FileUpload\File;
use Klein\Request;
use Klein\Response;
use App\models\utils\TableFieldMap as DbMap;

class AdminController extends BaseController
{
    /**
     * @var array
     */
    private $indexes = [];
    public $resultArray = [];
    public $notFoundArray = [];

    public $allHtml = '';

    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
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
        list($files, $header) = $uploader->store('csv');

        $syncedRowsCount = 0;

        if(count($files) > 0){
            /**
             * @var File $file
             */
            $file = $files[0];
            if ($file->completed) {
                $filePath =  $file->getRealPath();
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
                                            $model->find($fieldValue);
                                        }elseif($currentFieldName == 'period'){
                                            $periodConverted  = CsvTool::ConvertDateToYmd($row[$this->indexes[$currentFieldName]]);
                                            $model->period = $periodConverted;
                                        }elseif(isset($this->indexes[$currentFieldName])){
                                            $model->$currentFieldName =
                                                empty($row[$this->indexes[$currentFieldName]]) ?
                                                    $fieldValue :                   // If csv value is empty, then use the original
                                                    $row[$this->indexes[$currentFieldName]];    // If csv value is not empty, save it
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
        $head = null;
        foreach ($this->resultArray as $key => $tr) {
            if(is_null($head)){
                $keys = array_keys($tr);
                $head = '<tr>';
                foreach ($keys as $theKey) {
                    $head .= '<td>'.$theKey.'</td>';
                }
                $head .= '</tr>';
                $html .= $head;
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
        $html = '<br><h2>CSV rows not matched</h2><table border="1"><tbody><tr><td>Line #</td><td>Content</td></tr>';
        foreach ($this->notFoundArray as $csvFileLineNumber=>$rowData) {
            $html .= '<tr><td>'.$csvFileLineNumber.'</td><td>'.$rowData.'</td></tr>';
        }
        return $html .= '</tbody></table>';
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
                $map = DbMap::FinanceControllerTable();
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