<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    const TYPE_SHARED = 'shared';
    const TYPE_CUSTOM = 'custom';

    const METRIC_TRAINING = 'training';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'guides' => 'array',
        'metrics' => 'array'
    ];
}
