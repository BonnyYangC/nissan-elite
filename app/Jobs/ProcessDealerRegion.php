<?php

namespace App\Jobs;

use App\Models\DealerRegion;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessDealerRegion implements ShouldQueue
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
            $conditions = [
                'code' => trim($row['dcode'])
            ];
            $exists = DealerRegion::where($conditions)->exists();
            $data = $this->buildModelData($row);
            if (!$exists) {
                $data['created_at'] = Carbon::now();
            }
            DealerRegion::updateOrInsert($conditions, $data);
        }
    }

    private function buildModelData($row) {
        return [
            'region' => isset($row['rname'][0]) ? $row['rname'][0] : null,
            'region_code' => $row['deal~regi_rcode::rcode'],
            'category' => $row['dcat'],
            'category_code' => $row['dcat#'],
            'updated_at' => Carbon::now()
        ];
    }
}
