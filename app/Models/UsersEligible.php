<?php

namespace App\Models;

use App\Builders\UserEligiblesBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersEligible extends Model
{
    use HasFactory;
    protected $table = 'users_eligible';

    public function newEloquentBuilder($query): UserEligiblesBuilder {
        return new UserEligiblesBuilder($query);
    }
}
