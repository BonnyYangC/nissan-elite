<?php

namespace App\Models;

use App\Builders\PositionBuilder;
use App\Helper\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Position
 * @package App\Models
 * @property-read  string $code
 * @property-read  string $title
 * @property-read boolean $platinum_ranking
 */
class Position extends Model {

    use HasFactory;

    // protected $connection = 'mysql_nissan'; // Use the 'mysql_nissan' connection
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'platinum_ranking' => 'boolean'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code', 'title', 'platinum_ranking'
    ];

    const REGION_STAFF_POSITIONS = [
        Role::DISTRICT_SALES_MANAGER,
        Role::DEALER_TECHNICAL_SPECIALIST,
        Role::FRANCHISE_DEVELOPMENT_MANAGER,
        Role::FIELD_OPERATION_MANAGER,
        Role::REGIONAL_AFTER_SALES_MANAGER,
        Role::REGIONAL_FLEET_MANAGER,
        Role::REGIONAL_GENERAL_MANAGER,
        Role::REGIONAL_OPERATIONS_ANALYST,
        Role::REGIONAL_OPERATIONS_MANAGER,
        Role::REGIONAL_SALES_COORDINATOR,
        Role::REGIONAL_SALES_MANAGER,
        Role::NFSA,
        Role::HEAD_OFFICE,
        Role::NDM,
        Role::DGC
    ];

    const TECHNICIAN_POSITIONS = [Role::ADVANCED_TECHNICIAN, Role::MASTER_TECHNICIAN];
    
    const SEARCHABLE_POSITIONS = [
        Role::RETAIL_SALES_CONSULTANTS,
        Role::FLEET_SALES_EXECUTIVES,
        Role::SALES_MANAGER,
        Role::SERVICE_ADVISERS,
        Role::STOCK_CONTROLLER,
        Role::PARTS_MANAGER,
        Role::PARTS_SALES_REP,
        Role::SERVICE_MANAGER,
        Role::FI
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rewards() {
        return $this->hasOne(Reward::class, 'position', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metrics() {
        return $this->hasMany(Metric::class, 'position', 'code');
    }

    public function newEloquentBuilder($query): PositionBuilder {
        return new PositionBuilder($query);
    }
}
