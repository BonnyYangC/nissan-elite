<?php

namespace App\Models;

use App\Builders\UserPositionsBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 * @property string $employee_code
 * @property string $position_code
 */
class UserPositions extends Model
{
    use HasFactory;

    protected $table = 'user_positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_code',
        'position_code'
    ];

    public function newEloquentBuilder($query): UserPositionsBuilder {
        return new UserPositionsBuilder($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'position_code', 'position_code');
    }
}
