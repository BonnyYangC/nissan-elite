<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname', 'lastname', 'employee_code',
        'email', 'position_code',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'excellence_eligible' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function position() {
        return $this->hasOne(Position::class, 'code', 'position_code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dealer() {
        return $this->belongsTo(Dealer::class, 'dealer_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function region() {
        return $this->hasOne(Region::class, 'code', 'region_code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function results() {
        return $this->hasMany(Result::class, 'employee_code', 'employee_code')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function loyaltyPoints() {
        return $this->hasMany(History::class, 'member_id', 'employee_code')->get();
    }
}
