<?php

namespace Database\Seeders;

use App\Helper\Defination;
use App\Models\{Acl, Company, Faq, Metric, Position, Reward, User};
use App\Helper\Role;
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
        $this->loadData(__DIR__.'/companies_defination.json');
        $this->loadData(__DIR__.'/positions.json');
        $this->loadData(__DIR__.'/rewards.json');
        $this->loadData(__DIR__.'/metrics_defination.json');
        $this->loadData(__DIR__.'/admins.json');
        $this->loadData(__DIR__.'/acls.json');
        $this->loadData(__DIR__.'/faqs.json');

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
        // $this->seedPositions();
        // $this->seedCompanies();
        // $this->seedAdmins();
        // $this->seedAcls();
        // $this->seedRewards();
        $this->seedMetrics();
        // $this->seedFaqs();
    }

    /**
     *
     */
    private function seedPositions() {
        $positions = $this->data['positions'];
        foreach ($positions as $p) {
            $ep = Position::where('code', '=', $p['code'])->first();
            !$ep ? Position::create($p) : $ep->update();
        }
    }

    /**
     *
     */
    private function seedMetrics() {
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

    /**
     *
     */
    private function seedCompanies() {
        $companies = $this->data['companies'];
        foreach ($companies as $m) {
            Company::create($m);
        }
    }

    /**
     *
     */
    private function seedAdmins() {
        $admins = $this->data['admins'];
        foreach ($admins as $a) {
            $a['password'] = Hash::make($a['password']);
            $a['active'] = 1;
            User::create($a);
        }
    }

    /**
     *
     */
    private function seedAcls() {
        $acls = $this->data['acls'];
        foreach ($acls as $position => $as) {
            if ($position === 'REGION_STAFF') {
                $this->seedRegionStaffAcls($as);
                continue;
            }
            foreach ($as as $a) {
                $a['position'] = $position;
                Acl::create($a);
            }
        }
    }

    /**
     * @param array $acls
     */
    private function seedRegionStaffAcls(array $acls) {
        foreach (array_merge(Position::REGION_STAFF_POSITIONS, [Role::ADMIN]) as $position) {
            foreach ($acls as $a) {
                $a['position'] = $position;
                Acl::create($a);
            }
        }
    }

    /**
     *
     */
    private function seedRewards() {
        DB::table('rewards')->truncate();
        $rewards = $this->data['rewards'];
        foreach ($rewards as $r) {
            Reward::create($r);
        }
    }

    /**
     *
     */
    private function seedFaqs() {
        $faqs = $this->data['faqs'];
        foreach ($faqs as $f) {
            Faq::create($f);
        }
    }
}
