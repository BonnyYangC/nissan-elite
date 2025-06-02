<?php

namespace App\Http\Controllers;
use App\Helper\Defination;

class ProductChallengeController extends Controller
{
    public function __invoke() {
        $this->dataForView['menuName'] = Defination::PAGE_PRODUCT_CHALLENGE;
        $this->dataForView['events'] = json_decode(theme_config('product_challenge_events'));
        return $this->render('pages.product_challenge');
    }
}
