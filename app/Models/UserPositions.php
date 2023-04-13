<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property string $firstname
 * @property string $lastname
 * @property string $employee_code
 * @property string $position_code
 * @property string $region_code
 * @property boolean $excellence_eligible
 * @property-read Result[] $results
 * @property-read Dealer $dealer
 * @property-read Reward[] $rewards
 * @property-read History[] $loyaltyPoints
 * @property-read Region $region
 */
class UserPositions extends Model
{
    use HasFactory, SoftDeletes;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'position_code', 'position_code');
    }
}
