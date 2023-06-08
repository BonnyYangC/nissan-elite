<?php

namespace App\Services\DataMappingServices;

use App\Helper\Defination;
use App\Helper\Utility;
use App\Models\{Result, User};
use App\Services\DataMappingServices\MonthlyDataImpl\{MonthlyImportationTrait, MonthlyValidationTrait};

class MonthlyDataMapping {
    use MonthlyValidationTrait, MonthlyImportationTrait;

    /** @var array  */
    public $metricsMappingArray = [];

    /** @var array  */
    public $mappingArray = [
        'period' => 'mthyrg',
        'employee_code' => 'regi#',
        'position' => 'sp',

        'train_online' => 'points_train_online',
        'train_competency' => 'points_train_competency',
        'train_mastery' => 'points_train_mastery',
        'train_pathway' => 'points_train_pathway',
        'train_bonus' => 'points_train_bonus',

        'registration' => 'points_registration',
        'excellence' => 'points_excellence',
        'incentive' => 'points_incentive',
        'adjustment' => 'points_adjust',
        'credit_mtd' => 'POINTS_MTHLY',
        'credit_ytd' => 'POINTS_YTD',
        'lifetime' => 'POINTS_ytd_historical',
    ];

    private $actionType = Defination::ACTION_TYPE_SYNC;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(string $action) {
        $this->actionType = $action;
    }


    /**
     * get primary key according to data file type
     *
     * @return array
     */
    public function getKeyForModel(): array {
        $key = [];
        $key['primary'] = 'regi#';
        return $key;
    }

    /**
     * get model according data file type
     *
     * @param $key
     * @param $modelKey
     * @param $record
     * @return Result
     */
    public function getModel($modelKey, $record, $key) {
        return $this->actionType == Defination::ACTION_TYPE_SYNC ?
        $this->getModelForImportation($modelKey, $record, $key) :
        $this->getModelForValidation($modelKey, $record, $key);
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
    public function buildData($model, $row, $modelKey, $key){
        ini_set('max_execution_time', 180); //3 minutes
        return [
            'period'        => Utility::formatPeriod($row['mthyrg']),
            'employee_code' =>$row['regi#'],
            'position'      =>$row['sp'],
            'metrics' => $this->metricsMapping($row),

            'train_online' => isset($row['points_train_online']) && $row['points_train_online'] !== '' ? $row['points_train_online'] : 0,
            'train_competency' => isset($row['points_train_competency']) && $row['points_train_competency'] !== '' ? $row['points_train_competency'] : 0,
            'train_mastery' => isset($row['points_train_mastery']) && $row['points_train_mastery'] !== '' ? $row['points_train_mastery'] : 0,
            'train_pathway' => isset($row['points_train_pathway']) && $row['points_train_pathway'] !== '' ? $row['points_train_pathway'] : 0,
            'train_bonus' => isset($row['points_train_bonus']) && $row['points_train_bonus'] !== '' ? $row['points_train_bonus'] : 0,

            'registration'          =>$row['points_registration'] !== '' ? $row['points_registration'] : 0,
            'excellence'            =>$row['points_excellence'] !== '' ? $row['points_excellence'] : 0,
            'incentive'             =>$row['points_incentive'] !== '' ? $row['points_incentive'] : 0,
            'adjustment'            =>$row['points_adjust'] !== '' ? $row['points_adjust'] : 0,
            'credit_mtd'            =>$row['POINTS_MTHLY'] !== '' ? $row['POINTS_MTHLY'] : 0,
            'credit_ytd'            =>$row['POINTS_YTD'] !== '' ? $row['POINTS_YTD'] : 0,
            'lifetime'              =>$row['POINTS_ytd_historical'] !== '' ? $row['POINTS_ytd_historical'] : 0,

        ];
    }

    /**
     * @param $row
     * @return array
     */
    protected function metricsMapping($row): array {
        return array_reduce(array_keys($this->metricsMappingArray),
            function ($result, $key) use ($row) {
                $value = data_get($row, $this->getMetricsMappingField($key));
                // TBD: if no value from csv file, set to null. which is $value !== '' ? $value : null; 
                $result[$key] = $value; // retrive metric value from csv file, keep whatever it is
                return $result;
            }, []);
    }

    /**
     * to see if this record is ignored
     *
     * @param $value
     * @return bool
     */
    public static function isIgnored($value) {
        $result = false;
        return $result;
    }

    /**
     * @param string $employeeCode
     * @return bool
     */
    public function validate(string $employeeCode) {
        $model = User::where('employee_code', $employeeCode)->first();
        return $model ? true : false;
    }

    protected function getMetricsMappingField(string $metric) {
        return data_get($this->metricsMappingArray, $metric);
    }

}
