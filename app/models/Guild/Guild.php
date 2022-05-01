<?php

namespace App\Models\Guild;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{

    use HasFactory;

    const PLATINUM_MEMBERS = 'PLATINUM MEMBERS (500,000+)';
    const GOLD_MEMBERS = 'GOLD MEMBERS (325,000+)';
    const LIFETIME_MEMBERS = 'LIFETIME MEMBERS - RETIRED';
}
