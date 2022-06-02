<?php

namespace App\Http\Controllers;

use App\Services\ServiceResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller {

    /** @var ServiceResolver  */
    private $resolver;

    /**
     * Create a new controller instance.
     * @param ServiceResolver $resolver
     * @return void
     */
    public function __construct(ServiceResolver $resolver, Request $request) {
        parent::__construct($request);
        $this->resolver = $resolver;
    }

    /**
     * entry point
     *
     */
    public function loyalty() {
        $this->dataForView['menuName'] = 'loyalty';
        $this->resolver->gageService()->loyalty_status_level();
        //year to date
        $this->dataForView['ytd'] = $this->resolver->resultService()->getYearToDateData();

        //historical points
        $this->dataForView['historical'] = $this->resolver->historicalService()->getHistoricalData();
        return $this->render('pages.loyalty');
    }

    /**
     * entry point
     *
     */
    public function incentives() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'incentives';

        $this->dataForView['current'] = $this->resolver->incentivesService()->getIncentives('current', 'All');
        $this->dataForView['finished'] = $this->resolver->incentivesService()->getIncentives('finished', 'All');
        $this->dataForView['past'] = $this->resolver->incentivesService()->getIncentives('past', 'All');
        return $this->render('pages.incentives');
    }

    /**
     * entry point
     *
     */
    public function member_guide() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'member_guide';
        return $this->render('pages.member_guide');
    }

    /**
     * entry point
     *
     */
    public function program() {
        $this->dataForView['menuName'] = 'program';
        return $this->render('pages.program');
    }

    /**
     * entry point
     *
     */
    public function calendar() {
        $this->dataForView['menuName'] = 'calendar';
        $events = $this->resolver->eventService()->load();
        $this->dataForView['nissanEvents'] = json_encode($events);

        return $this->render('pages.calendar');
    }

    /**
     * entry point
     *
     */
    public function product_challenge() {
        $this->dataForView['menuName'] = 'product_challenge';
        return $this->render('pages.product_challenge');
    }

    /**
     * entry point
     *
     */
    public function awards() {
        $this->dataForView['menuName'] = 'awards';
        return $this->render('pages.awards');
    }

    /**
     * entry point
     *
     */
    public function account() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'account';
        return $this->render('pages.account');
    }

    /**
     * entry point
     *
     */
    public function faq() {
        $this->dataForView['menuName'] = 'faq';
        $this->dataForView['faqs'] = $this->resolver->faqService()->load();
        return $this->render('pages.faq');
    }
}
