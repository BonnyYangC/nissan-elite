<?php

namespace App\Models;

use App\Builders\RegionBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    // protected $connection = 'mysql_nissan'; // Use the 'mysql_nissan' connection
    
    const REGION_ALL = 'All';
    const REGION_EASTERN = 'Eastern';
    const REGION_NORTHERN = 'Northern';
    const REGION_SOUTHERN = 'Southern';
    const REGION_WESTERN = 'Western';

    public function newEloquentBuilder($query): RegionBuilder {
        return new RegionBuilder($query);
    }
}
