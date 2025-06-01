<?php

namespace App\Services\MetricsServices\Factories;

use App\Services\MetricsServices as MS;
use Illuminate\Contracts\Container\Container;

class TrainingFactory {
    private $container;

    protected $map = [
        'training' => MS\TrainingMetrics\Metrics::class
    ];

    public function __construct(Container $container) {
        $this->container = $container;
      }

    public function make(string $type)
    {
        if (!isset($this->map[$type])) {
            throw new \InvalidArgumentException("Unknown training metric type");
        }
    
        return $this->container->make($this->map[$type]);
    }
}