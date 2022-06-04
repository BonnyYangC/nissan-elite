<?php

namespace App\Http\Controllers;

use App\Models\Incentive;
use App\Services\IncentiveService;
use Illuminate\Http\Request;

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
