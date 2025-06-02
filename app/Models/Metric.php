<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    const METRICS_TYPE_TRAINING = 'training';
    const METRICS_TYPE_SHARED = 'shared';
    const METRICS_TYPE_CUSTOM = 'custom';
    
    const METRIC_D1 = 'd1';
    const METRIC_F1 = 'f1';
    const METRIC_5_STAR = '5_star';
    const METRIC_CE = 'ce';
    const METRIC_PERIOD_QUARTERLY = 'quarterly';
    
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
