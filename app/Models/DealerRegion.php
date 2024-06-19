<?php

namespace App\Models;

use App\Builders\DealerRegionsBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerRegion extends Model
{
    use HasFactory;
    protected $table = 'dealer_regions';

    public function newEloquentBuilder($query): DealerRegionsBuilder {
        return new DealerRegionsBuilder($query);
    }
}
