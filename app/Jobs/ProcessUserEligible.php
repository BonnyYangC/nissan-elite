<?php

namespace App\Jobs;

use App\Models\UsersEligible;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUserEligible implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->rows as $row) {
            UsersEligible::updateOrInsert([
                'employee_code' => trim($row['regi#_']),
            ], [
                'registered'=>$row['registered_'] === 'Registered' ? 1 : 0,
                'member'=>$row['elite_mbr'] === 'Y' ? 1: 0,
                'met_criteria' => $row['criteria_EOY_MET'] === 'YES' ? 1 : 0,
                'excellence_eligible' => $row['excellence_eligible'] === 'YES' ? 1: 0,
                'created_at' => now(),    // Only matters if inserting
                'updated_at' => now(),    // Always needed
            ]);
        }
    }
}
