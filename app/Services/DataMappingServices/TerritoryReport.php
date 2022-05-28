<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Models\TerritoryReport as TerritoryReportModel;
use Carbon\Carbon;

class TerritoryReport {

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct() { }


    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'regi#_';
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $actionType
     * @param $dataType
     * @param $modelKey
     * @param $record
     * @return TerritoryReportModel
     */
    public function getModel($actionType, $dataType, $modelKey, $record, $key) {
        $model = TerritoryReportModel::where('employee_code', trim($record[$modelKey['primary']]))->first();
        if( $actionType == Defination::ACTION_TYPE_SYNC && !$model){
            $model = new TerritoryReportModel();
            $model->updated_at = Carbon::now();
            $model->created_at = Carbon::now();
        }
        return $model;
    }

    /**
     * built data map for data uploader
     *
     * @param $model
     * @param [string] $dataType
     * @param [array] $row
     * @param [array] $modelKey
     * @param [string] $key
     * @return array
     */
    public function buildData($model, $dataType, $row, $modelKey, $key){
        ini_set('max_execution_time', 180); //3 minutes
        return [
            /*'dsm_full_name'         =>'elit~dreg_dcode::n_fullname',//'amba_deal~regi_rcode::n_fullname',
            'region_name'           =>'rname_',//'amba_deal~regi_rcode::r_name',
            'region_code'           =>'rcode_',//'amba_deal~regi_rcode::r_code',
            'dealer_code'           =>'dcode',//'d_code',
            'dealer_name'           =>'dname',//'d_name',
            'dealer_cat'            =>'dcat',//'d_cat',  // dealer's category, metro or district ...
            'sp_code'               =>'sp_code',
            'n_fullname'            =>'n_fullname',
            'position'              =>'position',*/
            'employee_code'         =>$row['regi#_'],
            'award_status'          =>$row['award_status'],
            'points_ytd_status'       =>$row['points_ytd_status_'] !== '' ? $row['points_ytd_status_'] : 0,
            'credits_monthly_04'    =>$row['elit~engi_regi#04mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#04mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_05'    =>$row['elit~engi_regi#05mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#05mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_06'    =>$row['elit~engi_regi#06mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#06mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_07'    =>$row['elit~engi_regi#07mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#07mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_08'    =>$row['elit~engi_regi#08mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#08mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_09'    =>$row['elit~engi_regi#09mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#09mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_10'    =>$row['elit~engi_regi#10mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#10mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_11'    =>$row['elit~engi_regi#11mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#11mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_12'    =>$row['elit~engi_regi#12mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#12mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_01'    =>$row['elit~engi_regi#01mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#01mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_02'    =>$row['elit~engi_regi#02mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#02mthyrg::POINTS_MTHLY_'] : 0,
            'credits_monthly_03'    =>$row['elit~engi_regi#03mthyrg::POINTS_MTHLY_'] !== '' ? $row['elit~engi_regi#03mthyrg::POINTS_MTHLY_'] : 0,
            'cr_ytd'                =>$row['points_ytd_status_'] !== '' ? $row['points_ytd_status_'] : 0,
            'cr_ytd_platinum'       =>$row['points_ytd_platinum_'] !== '' ? $row['points_ytd_platinum_'] : 0,
            'cr_ytd_lifetime'       =>$row['points_ytd_lifetime_'] !== '' ? $row['points_ytd_lifetime_'] : 0,
        ];
    }

    /**
     * to see if this record is ignored
     *
     * @param $type
     * @param $value
     * @return bool
     */
    public static function isIgnored($type, $value) {
        $result = false;
        return $result;
    }

}
