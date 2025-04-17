<?php

namespace Database\Seeders;

use App\Models\{Acl, Company, Position, User};
use App\Helper\Role;
use App\Models\Region;
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
        $this->loadData(__DIR__.'/regions.json');
        // $this->loadData(__DIR__.'/companies_defination.json');
        $this->loadData(__DIR__.'/positions.json');
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
        $this->seedRegions();
        $this->seedPositions();
        // $this->seedCompanies();
        $this->seedAdmins();
        $this->seedAcls();
    }

    /**
     *
     */
    private function seedRegions() {
        $regions = $this->data['regions'];
        foreach ($regions as $r) {
            $ep = Region::where('code', '=', $r['code'])->first();
            !$ep ? Region::create($r) : $ep->update();
        }
    }

    /**
     *
     */
    private function seedPositions() {
        $positions = $this->data['positions'];
        foreach ($positions as $p) {
            $ep = Position::where('code', '=', $p['code'])->first();
            !$ep ? Position::create($p) : $ep->update($p);
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
        DB::table('acls')->truncate();
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
}
