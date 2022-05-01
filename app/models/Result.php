<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Result
 * @var string $period
 * @package App\Models
 */
class Result extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'period' => 'integer',
        'credit_mtd' => 'float',
        'metrics' => 'array'
    ];
}
