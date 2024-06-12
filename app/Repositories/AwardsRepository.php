<?php

namespace App\Repositories;

use App\Models\Awards;
use App\Models\AwardsType;
use App\Models\Faq;
use Illuminate\Support\Collection;

class AwardsRepository {

    public function loadAll() {
        return [
            AwardsType::PLATINUM_NATIONAL => $this->processAwardsData(Awards::national()->get()),
            AwardsType::PLATINUM_STATE => $this->processAwardsData(Awards::state()->get()),
            AwardsType::GOLD_STATUS => Awards::gold()->get()->groupBy('sub_type')->toArray()
        ];
    }

    private function processAwardsData(\Illuminate\Database\Eloquent\Collection $collect) {
        return $collect->groupBy(function ($item, int $key) {
            return substr($item->sub_type, 3);
        })->toArray();
    }
}
