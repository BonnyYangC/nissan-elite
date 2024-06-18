<?php

namespace App\Models;

use App\Builders\TerritoryReportBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerritoryReport extends Model {
    use HasFactory;
    protected $table = 'territory_reports';

    public function newEloquentBuilder($query): TerritoryReportBuilder {
        return new TerritoryReportBuilder($query);
    }
}
