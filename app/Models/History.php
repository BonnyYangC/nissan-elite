<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Result
 * @var string $period
 * @package App\Models
 */
class History extends Model {
    use HasFactory;

    protected $connection = 'mysql_nissan'; // Use the 'mysql_nissan' connection
    protected $table = 'nissan_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'period', 'member_id', // should change to 'employee_code',
        'amount'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'period' => 'integer',
        'amount' => 'float'
    ];
}
