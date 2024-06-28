<?php

namespace App\Http\Controllers;
use App\Helper\Defination;

class ProductChallengeController extends Controller
{
    public function __invoke() {
        $this->dataForView['menuName'] = Defination::PAGE_PRODUCT_CHALLENGE;
        return $this->render('pages.product_challenge');
    }
}
