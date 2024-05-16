<?php

namespace App\Http\Controllers;

class ProductChallengeController extends Controller
{
    public function __invoke() {
        $this->dataForView['menuName'] = 'product_challenge';
        return $this->render('pages.product_challenge');
    }
}
