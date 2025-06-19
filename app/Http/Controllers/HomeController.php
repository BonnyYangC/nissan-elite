<?php

namespace App\Http\Controllers;

use App\Traits\User;

class HomeController {

    use User;

    public function index(){
        $trainingUrl = theme_config($this->getCurrentUser()->isMember() ? 'training_url_members' : 'training_url_region_HO');
        return view('home', ['trainingUrl' => $trainingUrl]);
    }
}
