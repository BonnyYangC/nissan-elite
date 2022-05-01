<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class BaseService {

    /** @var ServiceResolver */
    protected $serviceResolver;

    /**
     * Create a new service instance.
     *
     * @param ServiceResolver $serviceResolver
     * @return void
     */
    public function __construct(ServiceResolver $serviceResolver) {
        $this->serviceResolver = $serviceResolver;
    }

}
