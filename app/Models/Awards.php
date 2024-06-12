<?php

namespace App\Models;

use App\Builders\AwardBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Awards extends Model
{
    use HasFactory;

    public $timestamps = false;

    const nationalAwards = [
        AwardsType::PLATINUM_NATIONAL_FIRST
    ];
    
    const stateAwards = [
        AwardsType::PLATINUM_STATE_NSW,
        AwardsType::PLATINUM_STATE_QLD,
        AwardsType::PLATINUM_STATE_SA_NT,
        AwardsType::PLATINUM_STATE_VIC_TAS,
        AwardsType::PLATINUM_STATE_WA
    ];

    public function newEloquentBuilder($query): AwardBuilder {
        return new AwardBuilder($query);
    }
}
