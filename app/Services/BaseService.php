<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaseService {

    /** @var ServiceResolver */
    protected $serviceResolver;
    /** @var User */
    protected $currentUser;

    /**
     * Create a new service instance.
     *
     * @param ServiceResolver $serviceResolver
     * @return void
     */
    public function __construct(ServiceResolver $serviceResolver) {
        $this->serviceResolver = $serviceResolver;
        $this->currentUser = $this->getCurrentUser();
    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|null
     */
    public function getCurrentUser() {
        if (session('mock')) {
            return session('mock-user');
        }
        return Auth::user();
    }
}
