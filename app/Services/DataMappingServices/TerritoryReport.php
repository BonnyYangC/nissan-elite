<?php

namespace App\Services\DataMappingServices;

use Illuminate\Support\Facades\Validator;

class TerritoryReport extends Base {

    /** @var array  */
    public $mappingArray = [
        'employee_code' => 'regi#_',
        'award_status' => 'award_status',
        'credits_monthly_04' => 'elit~engi_regi#04mthyrg::POINTS_MTHLY',
        'credits_monthly_05' => 'elit~engi_regi#05mthyrg::POINTS_MTHLY',
        'credits_monthly_06' => 'elit~engi_regi#06mthyrg::POINTS_MTHLY',
        'credits_monthly_07' => 'elit~engi_regi#07mthyrg::POINTS_MTHLY',
        'credits_monthly_08' => 'elit~engi_regi#08mthyrg::POINTS_MTHLY',
        'credits_monthly_09' => 'elit~engi_regi#09mthyrg::POINTS_MTHLY',
        'credits_monthly_10' => 'elit~engi_regi#10mthyrg::POINTS_MTHLY',
        'credits_monthly_11' => 'elit~engi_regi#11mthyrg::POINTS_MTHLY',
        'credits_monthly_12' => 'elit~engi_regi#12mthyrg::POINTS_MTHLY',
        'credits_monthly_01' => 'elit~engi_regi#01mthyrg::POINTS_MTHLY',
        'credits_monthly_02' => 'elit~engi_regi#02mthyrg::POINTS_MTHLY',
        'credits_monthly_03' => 'elit~engi_regi#03mthyrg::POINTS_MTHLY',
        'cr_ytd' => 'points_ytd_status_',
        'cr_ytd_platinum' => 'points_ytd_platinum_',
        'cr_ytd_lifetime' => 'points_ytd_historical_',
    ];

    // implement Ignore interface
    public static function isIgnored(array $record, array $key): bool {
        return in_array($record[$key['dealer']], [55, NULL]);
    }

    // implement Valid interface
    public function isValidate(array $record, array $key): bool {
        $validator = Validator::make($record, [
            'regi#_' => 'required|string|exists:users,employee_code',
            'dcode' => 'required|string|exists:dealers,code'
        ]);
        return !$validator->fails();
        // $dealer = Dealer::where('code', $record[$key['dealer']])->first();
        // $employee = User::where('employee_code', $record[$key['employee']])->first();
        // return $dealer && $employee ? true : false;
    }

    public function getValidateMessage(): string {
        return 'Please check employee/dealer exist or not!';
    }

    public function getKeyForValidate(): array {
        $key = [];
        $key['employee'] = 'regi#_';
        $key['dealer'] = 'dcode';
        return $key;
    }

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
     * built data map for data uploader
     *
     * @param $model
     * @param [array] $row
     * @param [array] $modelKey
     * @param [string] $key
     * @return array
     */
    public function buildData($row){
        ini_set('max_execution_time', 180); //3 minutes
        return [
            // 'employee_code'         =>$row['regi#_'],
            'award_status'          =>$row['award_status'],
            'credits_monthly_04'    =>$row['elit~engi_regi#04mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#04mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_05'    =>$row['elit~engi_regi#05mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#05mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_06'    =>$row['elit~engi_regi#06mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#06mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_07'    =>$row['elit~engi_regi#07mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#07mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_08'    =>$row['elit~engi_regi#08mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#08mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_09'    =>$row['elit~engi_regi#09mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#09mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_10'    =>$row['elit~engi_regi#10mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#10mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_11'    =>$row['elit~engi_regi#11mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#11mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_12'    =>$row['elit~engi_regi#12mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#12mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_01'    =>$row['elit~engi_regi#01mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#01mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_02'    =>$row['elit~engi_regi#02mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#02mthyrg::POINTS_MTHLY'] : 0,
            'credits_monthly_03'    =>$row['elit~engi_regi#03mthyrg::POINTS_MTHLY'] !== '' ? $row['elit~engi_regi#03mthyrg::POINTS_MTHLY'] : 0,
            'cr_ytd'                =>$row['points_ytd_status_'] !== '' ? $row['points_ytd_status_'] : 0,
            'cr_ytd_platinum'       =>$row['points_ytd_platinum_'] !== '' ? $row['points_ytd_platinum_'] : 0,
            'cr_ytd_lifetime'       =>$row['points_ytd_historical_'] !== '' ? $row['points_ytd_historical_'] : 0,  //for Point YTD Historical
        ];
    }
}
