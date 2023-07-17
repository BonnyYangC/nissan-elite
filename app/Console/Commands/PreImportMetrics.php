<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helper\Defination;
use App\Models\Metric;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreImportMetrics extends Command
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
    protected $data;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->loadData(__DIR__.'/metrics_defination.json');

        try {
            Model::unguard();
            DB::beginTransaction();
            $this->importMetrics();
            DB::commit();
            var_dump("\nMetrics import finished");
        } catch (Throwable $ex) {
            var_dump("\nMetrics import failed: { $ex->getMessage() }");
            DB::rollBack();
            throw $ex;
        } finally{
            Model::reguard();
        }
    }

    /**
     * @param $fileName
     */
    private function loadData($fileName) {
        $data = json_decode(file_get_contents($fileName), true);
        $this->data = is_array($this->data) ? array_merge($this->data, $data) : $data;
    }

    /**
     *
     */
    private function importMetrics() {
        DB::table('metrics')->truncate();
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
            Metric::create($m);
        }
    }

    /**
     * @param array $metrics
     */
    private function seedCustomMetrics(array $metrics) {
        // $positions = Position::get()->keyBy('code');
        foreach ($metrics as $position => $ms) {
            foreach ($ms as $m) {
                $m['type'] = Defination::METRICS_TYPE_CUSTOM;
                $m['position'] = $position;
                Metric::create($m);
            }
        }
    }

}
