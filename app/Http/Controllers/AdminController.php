<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Helper\Role;
use App\Helper\JsonBuilder;
use App\Models\Event;
use App\Models\Faq;
use App\Models\Incentive;
use App\Models\User;
use App\Services\DataService;
use Illuminate\Http\Request;

class AdminController extends Controller {

    /** @var DataService  */
    private $dataService;

    /**
     * Create a new controller instance.
     * @param DataService $dataService
     * @return void
     */
    public function __construct(DataService $dataService, Request $request) {
        parent::__construct($request);
        $this->dataService = $dataService;
    }

    /**
     * entry point
     *
     */
    public function dashboard() {
        $this->dataForView['menuName'] = 'dashboard';
        $this->dataForView['positions'] = $this->dataService->getPositions();
        $this->dataForView['summary'] = [
            Defination::DATA_TYPE_RANKING => 'Nissan Rankings',
            Defination::DATA_TYPE_TERRITORY_REPORT =>'Region Territory Report'
        ];
        $this->dataForView['users_menu'] = [
            Defination::DATA_TYPE_USERS_INFO => 'User Data',
            Defination::DATA_TYPE_DEALERS_INFO =>'Dealer Data',
            Defination::DATA_TYPE_REGION_STAFF_INFO  =>'Region Staff',
            Defination::DATA_TYPE_LOYALTY_HISTORICAL =>'Loyalty Historical'
        ];
        return $this->render('pages.backend.dashboard');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     * @throws \League\Csv\Exception
     */
    public function data_process(Request $request) {

        $actonType = $request->input('action_type');
        $dataType = $request->input('for');

        $parameter = [
            'year' => config('elite.YEAR', 2021),
            'month' => $request->input('month'),
        ];

        if ($request->hasFile('file')) {
            $dataFile = $request->file->storeAS('file', $dataType.date('Y-m-d').'.csv', 'public');
            if($actonType == Defination::ACTION_TYPE_SYNC){
                $this->dataForView['result'] = $this->dataService->importation($dataFile, $dataType);
            }else{
                $this->dataForView['result'] = $this->dataService->validation($dataFile, $dataType, $parameter);
            }

        }
        return $this->render('pages.backend.resulting');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function system_config(Request $request) {

        $content = [
            'PROGRAM_NAME' => $request->input('program_name'),
            'PROGRAM_SHORT_NAME' => $request->input('program_short_name'),
            'PROGRAM_SHORT_NAME_WITH_YEAR' => $request->input('program_short_name_with_year'),
            'PROGRAM_I_ELITE' => $request->input('program_i_elite'),
            'PROGRAM_DEALERSHIP' => $request->input('program_dealership'),
            'YEAR' => $request->input('year'),
            'PROGRAM_AWARD_UNIT' => $request->input('program_award_unit'),
            'PRODUCT_CHALLENGE_WINNER' => $request->input('product_challenge_winner'),
            'PAGE_SIZE' => $request->input('page_size'),
            'SUPPORT_EMAIL_ADDRESS' => $request->input('support_email'),
            'SUPPORT_EMAIL_NAME' => $request->input('support_email_name'),
            'ADMIN_USER' => $request->input('admin_user'),
            'ADMIN_PASSWORD' => $request->input('admin_password')
        ];

        config($content);

        file_put_contents(base_path().'/config/elite.php', '<?php return ' . var_export($content, true) . ';');

        return redirect()->back();

    }

    /**
     * @param Request $request
     * @param string $type
     */
    public function data_export(Request $request, string $type) {
        return $this->dataService->export($type, $request->input());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function calendars() {
        $this->dataForView['events'] = $this->dataService->loadEvents();
        return $this->render('pages.backend.content_manager.events');
    }

    /**
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function event_info(Event $event) {
        $this->dataForView['event'] = $event;
        $this->dataForView['incentives'] = $this->dataService->loadIncentives();
        return $this->render('pages.backend.content_manager.event_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function event_edit(Request $request) {
        $this->dataService->updateEvent($request->input());
        return redirect('admin/calendars');

    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function event_delete(Event $event) {
        $this->dataService->deleteEvent($event);
        return redirect()->back();

    }

    public function incentives() {
        $this->dataForView['incentives'] = $this->dataService->loadIncentivesByPeriod();
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

        $this->dataService->updateIncentive($request);
        return redirect('admin/incentives');

    }

    /**
     * @param Incentive $incentive
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function incentive_delete(Incentive $incentive) {
        $this->dataService->deleteIncentive($incentive);
        return redirect()->back();

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function faqs() {
        $this->dataForView['faqs'] = $this->dataService->loadFaqs();
        return $this->render('pages.backend.content_manager.faqs');
    }

    /**
     * @param Faq $faq
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function faq_info(Faq $faq) {
        $this->dataForView['faq'] = $faq;
        return $this->render('pages.backend.content_manager.faq_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function faq_edit(Request $request) {

        $this->dataService->updateFaq($request);
        return redirect('admin/faqs');

    }

    /**
     * @param Faq $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function faq_delete(Faq $faq) {
        $this->dataService->deleteFaq($faq);
        return redirect()->back();

    }
}
