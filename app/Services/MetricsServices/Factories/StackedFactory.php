<?php

namespace App\Services\MetricsServices\Factories;

use App\Services\MetricsServices as MS;
use Illuminate\Contracts\Container\Container;

class StackedFactory {
    private $container;

    protected $map = [
        'combined' => MS\StackedMetrics\Combined\Stacked::class,
        'individual' => MS\StackedMetrics\Individual\Stacked::class
    ];

    public function __construct(Container $container) {
        $this->container = $container;
      }

    public function make(string $type, string $position)
    {
        if (!isset($this->map[$type])) {
            throw new \InvalidArgumentException("Unknown stacked metric type");
        }
    
        return $this->container->make($this->map[$type], ['position' => $position]);
    }
}