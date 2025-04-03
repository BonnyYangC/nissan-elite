<?php

namespace App\Console\Commands;

use App\Models\Reward;
use Illuminate\Support\Facades\DB;

class PreImportRewards extends PreImportJson
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pre-import:rewards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pre import rewards defination from json file';
    protected $fileName = 'rewards.json';

    /**
     *
     */
    protected function importData() {
        DB::table('rewards')->where('year', '=', config('view.theme'))->delete();
        $rewards = $this->data['rewards'];
        foreach ($rewards as $r) {
            Reward::factory()->create($r);
        }
    }
}
