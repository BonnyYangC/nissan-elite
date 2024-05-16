<?php

namespace App\Http\Controllers;

class AwardsController extends Controller
{
    public function __invoke() {
        $this->dataForView['menuName'] = 'awards';
        return $this->render('pages.awards');
    }
}
