<?php

namespace App\Models;

use App\Builders\RewardBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    public function newEloquentBuilder($query): RewardBuilder {
        return new RewardBuilder($query);
    }
}
