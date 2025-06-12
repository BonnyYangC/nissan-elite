<?php

namespace App\Services\DataServices\Factories;

use App\Helper\Defination;
use App\Services\DataMappingServices as DMS;
use Illuminate\Contracts\Container\Container;

class ImporterFactory
{
    private $container;
    private $individualFactory;

    protected $map = [
        Defination::DATA_TYPE_USERS_INFO => DMS\ImportationImpl\User::class,
        Defination::DATA_TYPE_DEALERS_INFO => DMS\ImportationImpl\Dealer::class,
        Defination::DATA_TYPE_REGION_STAFF_INFO => DMS\ImportationImpl\RegionStaff::class,
        Defination::DATA_TYPE_LOYALTY_HISTORICAL => DMS\ImportationImpl\LoyaltyHistorical::class,
        Defination::DATA_TYPE_RANKING => DMS\ImportationImpl\Ranking::class,
        Defination::DATA_TYPE_TERRITORY_REPORT => DMS\ImportationImpl\TerritoryReport::class
    ];

    public function __construct(Container $container, IndividualFactory $individualFactory) {
        $this->container = $container;
        $this->individualFactory = $individualFactory;
      }

    public function make(string $type)
    {
        if (!in_array($type, array_keys($this->map))) {
          return $this->individualFactory->make($type, Defination::ACTION_TYPE_SYNC);
        }
        if (!isset($this->map[$type])) {
            throw new \InvalidArgumentException("Unknown importor type");
        }
    
        return $this->container->make($this->map[$type]);
    }
}