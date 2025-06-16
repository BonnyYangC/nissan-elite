<?php

namespace App\Services;

use Illuminate\Contracts\Container\BindingResolutionException;

class ServiceResolver {

    /**
     * @return RankingService
     * @throws BindingResolutionException
     */
    public function rankingService(): RankingService {
        return $this->make(RankingService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function resultService(): ResultService {
        return $this->make(ResultService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function rewardsService(): RewardsService {
        return $this->make(RewardsService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function statusService(): StatusService {
        return $this->make(StatusService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function territoryReportService(): TerritoryReportService {
        return $this->make(TerritoryReportService::class);
    }

    /**
     * @param string $abstract
     * @param array $parameters
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function make(string $abstract, array $parameters = []) {
        try {
            return app()->make($abstract, $parameters);
        } catch (BindingResolutionException $exception) {
            throwException($exception);
        }
    }
}
