<?php

namespace App\Http\Controllers;


class FutureSalesController extends Controller {

    /**
     * entry point
     *
     */
    public function future_sales() {
        $this->dataForView['menuName'] = 'future_sales';
        return $this->render('pages.future_sales');
    }

    /**
     * entry point
     *
     */
    public function future_sales_explanation() {
        $this->dataForView['menuName'] = 'future_sales_explanation';
        return $this->render('pages.future_sales.explanation');
    }

    /**
     * entry point
     *
     */
    public function future_sales_contact_schedule() {
        $this->dataForView['menuName'] = 'future_sales_contact_schedule';
        return $this->render('pages.future_sales.contact_schedule');
    }

    /**
     * entry point
     *
     */
    public function future_sales_postcard() {
        $this->dataForView['menuName'] = 'future_sales_postcard';
        $title = "Can I please place an order for Future Sales postcards at zero cost to our Dealer.%0d%0d";
        $content1 = "The initial order to Dealers is Category A%26B%3a 20 postcards and Category C%3a 10 postcards.%0d%0d";
        $content2 = "Contact details for delivery are..%0d%0d";
        $content3 = "Name%3a%0d%0dDealer%3a%0d%0d";
        $content4 = "Information on Future Sales can be found on our ELITE website at www.nissanelite.com.au%0d%0d%0d";
        $signOff = "Regards%0d%0dNissan ELITE Service Centre";
        $this->dataForView['mailContent'] = $title . $content1 . $content2 . $content3 . $content4 . $signOff;
        return $this->render('pages.future_sales.postcard');
    }
}
