<?php

namespace App\Models;

use App\Builders\IncentiveBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incentive extends Model {
    use HasFactory;

    public function newEloquentBuilder($query): IncentiveBuilder {
        return new IncentiveBuilder($query);
    }
}
