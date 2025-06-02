<?php

namespace App\Models;

use App\Builders\EventBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory;

    protected $connection = 'mysql_nissan'; // Use the 'mysql_nissan' connection

    public function incent() {
        return $this->hasOne(Incentive::class, 'id', 'incentive');
    }

    public function newEloquentBuilder($query): EventBuilder {
        return new EventBuilder($query);
    }
}
