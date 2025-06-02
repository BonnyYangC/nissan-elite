<?php

namespace App\Repositories;

use App\Models\Metric;
use Illuminate\Support\Collection;

class MetricsRepository {


    /**
     * @return mixed
     */
    public function getSharedMetrics() {
        return Metric::where('type', '=', Metric::METRICS_TYPE_SHARED)
            ->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return mixed
     */
    public function getAllMetricsByPosition(string $position) {
        return Metric::where('position', '=', $position)
            ->orderBy('order')->get();
    }

    /**
     * @param string $position
     * @return Collection
     */
    public function getMetricsByPosition(string $position): Collection {
        return Metric::where('position', '=', $position)
            ->where('identifier', '!=', Metric::METRICS_TYPE_TRAINING)
            ->orderBy('order')
            ->get();
    }

    /**
     * @param string $position
     * @return Metric | null
     */
    public function getTrainingMetricByPosition(string $position) {
        return Metric::where('position', '=', $position)
            ->where('identifier', '=', Metric::METRICS_TYPE_TRAINING)->first();
    }

}
