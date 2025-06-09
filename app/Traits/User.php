<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait User {

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed|null
     */
    protected function getCurrentUser() {
        if (session('mock')) {
            return session('mock-user');
        }
        return Auth::user();
    }
}
