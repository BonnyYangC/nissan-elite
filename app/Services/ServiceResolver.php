<?php

namespace App\Services;

use Illuminate\Contracts\Container\BindingResolutionException;

class ServiceResolver {

    /**
     * Create a new service instance.
     *
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
    public function metricsService(): MetricsService {
        return $this->make(MetricsService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function historicalService(): HistoricalService {
        return $this->make(HistoricalService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function incentivesService(): IncentiveService {
        return $this->make(IncentiveService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function guildService(): GuildService {
        return $this->make(GuildService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function gageService(): GageService {
        return $this->make(GageService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function faqService(): FaqService {
        return $this->make(FaqService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function positionService(): PositionService {
        return $this->make(PositionService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function regionService(): RegionService {
        return $this->make(RegionService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function userService(): UserService {
        return $this->make(UserService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function dealerService(): DealerService {
        return $this->make(DealerService::class);
    }

    /**
     * Create a new service instance.
     *
     */
    public function eventService(): EventService {
        return $this->make(EventService::class);
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
