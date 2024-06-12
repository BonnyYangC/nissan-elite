<?php

namespace App\Console\Commands;

use App\Helper\Defination;
use App\Models\Metric;
use Illuminate\Support\Facades\DB;

class PreImportMetrics extends PreImportJson
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pre-import:metrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre import metrics defination from json file';
    protected $fileName = 'metrics_defination.json';

    /**
     *
     */
    protected function importData() {
        DB::table('metrics')->where('year', '=', config('elite.YEAR'))->delete();
        $metrics = $this->data['metrics'];
        $this->seedSharedMetrics(data_get($metrics, Defination::METRICS_TYPE_SHARED, []));
        $this->seedCustomMetrics(data_get($metrics, Defination::METRICS_TYPE_CUSTOM, []));
    }

    /**
     * @param array $metrics
     */
    private function seedSharedMetrics(array $metrics) {
        foreach ($metrics as $m) {
            $m['type'] = Defination::METRICS_TYPE_SHARED;
            Metric::factory()->create($m);
        }
    }

    /**
     * @param array $metrics
     */
    private function seedCustomMetrics(array $metrics) {
        foreach ($metrics as $position => $ms) {
            foreach ($ms as $m) {
                $m['type'] = Defination::METRICS_TYPE_CUSTOM;
                $m['position'] = $position;
                Metric::factory()->create($m);
            }
        }
    }

}
