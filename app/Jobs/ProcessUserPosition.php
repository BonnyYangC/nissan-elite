<?php

namespace App\Jobs;

use App\Models\UserPositions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUserPosition implements ShouldQueue
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
            UserPositions::updateOrInsert([
                'employee_code' => trim($row['regi#']),
                'position_code' => trim($row['sp']),
            ], [
                'created_at' => now(),    // Only matters if inserting
                'updated_at' => now(),    // Always needed
            ]);
        }
    }
}
