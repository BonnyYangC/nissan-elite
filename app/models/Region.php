<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    const REGION_ALL = 'All';
    const REGION_EASTERN = 'Eastern';
    const REGION_NORTHERN = 'Northern';
    const REGION_SOUTHERN = 'Southern';
    const REGION_WESTERN = 'Western';
}
