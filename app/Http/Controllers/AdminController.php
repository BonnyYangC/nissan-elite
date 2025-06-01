<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Services\PositionService;
use Illuminate\Http\Request;

class AdminController extends Controller {

    /** @var PositionService  */
    private $service;

    public function __construct(PositionService $positionService, Request $request) {
        parent::__construct($request);
        $this->service = $positionService;
    }

    /**
     * entry point
     *
     */
    public function dashboard() {
        $this->dataForView['menuName'] = Defination::PAGE_DASHBOARD;
        $this->dataForView['positions'] = $this->service->getPositionsWithT();
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
     * @return mixed
     */
    public function system_config(Request $request) {

        $content = [
            'PROGRAM_NAME' => $request->input('program_name'),
            'PROGRAM_SHORT_NAME' => $request->input('program_short_name'),
            // 'PROGRAM_SHORT_NAME_WITH_YEAR' => $request->input('program_short_name_with_year'),
            'PROGRAM_I_ELITE' => $request->input('program_i_elite'),
            'PROGRAM_DEALERSHIP' => $request->input('program_dealership'),
            // 'YEAR' => $request->input('year'),
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

}
