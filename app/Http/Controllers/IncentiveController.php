<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Models\Incentive;
use App\Services\IncentiveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncentiveController extends Controller {

    /** @var IncentiveService  */
    private $service;

    /**
     * Create a new controller instance.
     * @param IncentiveService $service
     * @return void
     */
    public function __construct(IncentiveService $service, Request $request) {
        parent::__construct($request);
        $this->service = $service;
    }

    /**
     * entry point
     *
     */
    public function index() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = Defination::PAGE_INCENTIVES;

        $this->dataForView['current'] = $this->service->getIncentives('current', 'All');
        $this->dataForView['finished'] = $this->service->getIncentives('finished', 'All');
        $this->dataForView['past'] = $this->service->getIncentives('past', 'All');
        return $this->render('pages.incentives');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function incentives() {
        $this->dataForView['incentives'] = $this->service->loadIncentivesByPeriod();
        return $this->render('pages.backend.content_manager.incentives');
    }

    /**
     * @param Incentive $incentive
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function incentive_info(Incentive $incentive) {
        $this->dataForView['incentive'] = $incentive;
        return $this->render('pages.backend.content_manager.incentive_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function incentive_edit(Request $request) {

        $this->service->updateIncentive($request);
        return redirect('admin/incentives');

    }

    /**
     * @param Incentive $incentive
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function incentive_delete(Incentive $incentive) {
        $this->service->delete($incentive);
        return redirect()->back();

    }
}
