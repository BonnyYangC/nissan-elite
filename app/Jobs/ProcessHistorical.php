<?php

namespace App\Jobs;

use App\Models\History;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessHistorical implements ShouldQueue
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
        // update POINTS_YTD to history
        foreach ($this->rows as $row) {
            History::updateOrInsert([
                'member_id' => trim($row['regi#']),
                'period' => config('app.theme').'-01-01'
            ], [
                'amount' => $row['POINTS_YTD'],
                'created_at' => now(),    // Only matters if inserting
                'updated_at' => now(),    // Always needed
            ]);
        }
    }
}
