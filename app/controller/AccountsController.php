<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 2:42 PM
 */

namespace App\controller;
use App\models\nissan\Events;
use App\models\nissan\Incentives;
use App\models\role\IRole;
use App\models\utils\RoleFactory;
use Klein\Request;
use Klein\Response;
use App\models\User;

class AccountsController extends DashboardController
{
    /**
     * StaticPagesController constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Load metrics page
     */
    public function metrics(){
        $this->dataForView['currentUri'] = 'Metrics';
        // Load user's metrics data
        $this->fetchUserMetricsData();

        /**
         * @var IRole $role
         */
        $role = RoleFactory::GetRole(
            $this->userObject->position,
            $this->userObject
        );
        $this->_prepareForMetricsData($role);
        $this->dataForView['monthsArray'] = get_months_array();

        $this->render('dashboard/metrics/'.$role->getTemplateName());
        return;
    }

    /**
     * Refined load metrics data
     * @param IRole $role
     * @return bool
     */
    private function _prepareForMetricsData(IRole $role){
        if(!$role){
            return false;
        }
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->getTemplateName();
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/utils.js') // new way to render the chart
        ];
        return true;
    }

    /**
     * Load incentives page
     */
    public function incentives(){
        $this->dataForView['currentUri'] = 'Incentives';
        $status = strtoupper($this->request->param('status'));
        $this->dataForView['status']        = $status;

        $region = 'All';
        switch ($this->userObject->region){
            case 'N':
                $region = 'Northern';
                break;
            case 'S':
                $region = 'Southern';
                break;
            case 'W':
                $region = 'Western';
                break;
            case 'E':
                $region = 'Eastern';
                break;
        }

        $this->dataForView['current']       = Incentives::GetCurrent($region);
        $this->dataForView['finished']      = array_chunk(Incentives::GetJustFinished($region),3);
        $this->dataForView['past']          = array_chunk(Incentives::GetPast($region),3);

        $this->dataForView['registered']            = $this->userObject->registered === 'YES';
        $this->dataForView['extra_css'] = [
            asset('css/fotorama.css')
        ];
        $this->dataForView['extra_js'] = [
            asset('js/fotorama.js')
        ];

        $this->render('dashboard/incentives');
    }

    /**
     * Load account page
     */
    public function account(){
        $this->dataForView['currentUri'] = 'Account';
        $this->dataForView['user'] = $this->userObject;
        $this->render('dashboard/account');
        return;
    }

    /**
     * Load calendar view
     */
    public function calendar(){
        $this->dataForView['currentUri'] = 'Calendar';

        $region = 'All';
        switch ($this->userObject->region){
            case 'N':
                $region = 'Northern';
                break;
            case 'S':
                $region = 'Southern';
                break;
            case 'W':
                $region = 'Western';
                break;
            case 'E':
                $region = 'Eastern';
                break;
        }

        $nissanEvents = Events::LoadByRegion($region);

        $this->dataForView['nissanEvents'] = $nissanEvents;
        $this->dataForView['extra_css'] = [
//            asset('/css/bulma/bulma-calendar.min.css'),
            asset('/includes/calendar/bootstrap-year-calendar.min.css'),
        ];
        $this->dataForView['extra_js'] = [
            asset('/includes/calendar/bootstrap-year-calendar.min.js')
        ];

        $this->render('dashboard/calendar');
        return;
    }

    public function my_team(){
        $this->dataForView['currentUri'] = 'my-team';
        $param = [
            'sortBy' => $this->request->param('sortby'),
            'order' => $this->request->param('order'),
        ];
        
        $this->dataForView['teamMembers'] = User::getTeamMembersByRole($this->dataForView['currentUser'], $param);

        $this->render('dashboard/my_team');
        return;
    }
}
