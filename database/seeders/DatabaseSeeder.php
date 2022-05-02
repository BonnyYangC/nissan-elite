<?php

namespace Database\Seeders;

use App\Models\Acl;
use App\Models\Company;
use App\Models\Metric;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    protected $data;
    protected $total;

    /**
     * Seed the application's database.
     *
     * @throws \Throwable
     */
    public function run()
    {
        $this->loadData(__DIR__.'/metrics_defination.json');
        $this->loadData(__DIR__.'/companies_defination.json');
        $this->loadData(__DIR__.'/admins.json');
        $this->loadData(__DIR__.'/acls.json');

        try {
            Model::unguard();
            DB::beginTransaction();
            $this->seed();
            DB::commit();
            var_dump("\nDatabase seed finished");
        } catch (Throwable $ex) {
            var_dump("\nDatabase seed failed: { $ex->getMessage() }");
            DB::rollBack();
            throw $ex;
        } finally{
            Model::reguard();
        }
    }

    /**
     * @param $fileName
     */
    protected function loadData($fileName) {
        $data = json_decode(file_get_contents($fileName), true);
        $total = 0;
        foreach ($data as $k => $v) {
            if(is_array($v)) {
                $total += count($v);
            }
        }
        $this->total += $total;
        $this->data = is_array($this->data) ? array_merge($this->data, $data) : $data;
    }

    /**
     *
     */
    protected function seed() {
        $this->seedCompanies();
        $this->seedAdmins();
        $this->seedAcls();
        $this->seedMetrics();
    }

    /**
     *
     */
    private function seedMetrics() {
        $metrics = $this->data['metrics'];
        $this->seedSharedMetrics(data_get($metrics, Metric::TYPE_SHARED, []));
        $this->seedCustomMetrics(data_get($metrics, Metric::TYPE_CUSTOM, []));
    }

    private function seedSharedMetrics(array $metrics) {
        foreach ($metrics as $m) {
            $m['type'] = Metric::TYPE_SHARED;
            Metric::create($m);
        }
    }

    private function seedCustomMetrics(array $metrics) {
        // $positions = Position::get()->keyBy('code');
        foreach ($metrics as $position => $ms) {
            foreach ($ms as $m) {
                $m['type'] = Metric::TYPE_CUSTOM;
                $m['position'] = $position;
                Metric::create($m);
            }
        }
    }

    private function seedCompanies() {
        $companies = $this->data['companies'];
        foreach ($companies as $m) {
            Company::create($m);
        }
    }

    private function seedAdmins() {
        $admins = $this->data['admins'];
        foreach ($admins as $a) {
            $a['password'] = Hash::make($a['password']);
            $a['active'] = 1;
            User::create($a);
        }
    }

    private function seedAcls() {
        $acls = $this->data['acls'];
        foreach ($acls as $position => $as) {
            foreach ($as as $a) {
                $a['position'] = $position;
                Acl::create($a);
            }
        }
    }
}
