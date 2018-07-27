<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 2:42 PM
 */

namespace App\controller;
use App\models\nissan\DataSource;
use App\models\nissan\Events;
use App\models\nissan\Incentives;
use App\models\role\FI;
use App\models\role\FinanceController;
use App\models\role\FleetSalesManager;
use App\models\role\PartsManager;
use App\models\User;
use Klein\Request;
use Klein\Response;

class AccountsController extends DashboardController
{
    /**
     * Data for metrics
     * @var null
     */
    private $metricsData = null;
    private $excellence = null;

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
        $overrideRole = $this->request->param('override_role');

        if(!$overrideRole){
            $data = DataSource::Query($this->userObject);
            $this->metricsData = $data['result']['Results'];
            $this->excellence = $data['result']['Excellence'];
            $position_to_use = $this->userObject->position;
        }else{
            // For multiple role support
            $position_to_use =  null;
        }

        switch ($position_to_use){
            case User::FI:
                $this->_prepareForFinanceAndInsurance();
                break;
            case User::FINANCE_CONTROLLER:
                $this->_prepareForFinanceController();
                break;
            case User::PARTS_MANAGER:
                $this->_prepareForPartsManager();
                break;
            case User::FLEET_SALES_MANAGER:
                $this->_prepareForFleetSalesManager();
                break;
            default:
                break;
        }
        $this->render('dashboard/metrics/'.$this->dataForView['metrics_template_file_name']);
        return;
    }

    /**
     * Prepare metrics data for Parts Manager
     */
    private function _prepareForFleetSalesManager(){
        $role = new FleetSalesManager($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->name.'.js')
        ];
    }

    /**
     * Prepare metrics data for Parts Manager
     */
    private function _prepareForPartsManager(){
        $role = new PartsManager($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->name.'.js')
        ];
    }

    /**
     * Prepare metrics data for Finance Controller
     */
    private function _prepareForFinanceController(){
        $financeController = new FinanceController($this->userObject);
        $this->dataForView['metrics'] = $financeController->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $financeController->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/finance_controller.js')
        ];
    }

    /**
     * Prepare metrics data for Finance And Insurance
     */
    private function _prepareForFinanceAndInsurance(){
        $financeAndInsurance = new FI($this->userObject);
        $this->dataForView['metrics'] = $financeAndInsurance->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $financeAndInsurance->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/fi.js')
        ];
    }

    /**
     * Load incentives page
     */
    public function incentives(){
        $status = strtoupper($this->request->param('status'));

        $current=$thumb=$finished=$past='';
        $incentives = Incentives::Load($status);

        $count=0;
        foreach ($incentives as $tmp) {
            $count++;
            $current.='<div class="' . ($count==1 ? 'active ' : '') . 'item" data-slide-number="' . ($count-1) . '">
								' . (empty($tmp['pdf']) ? '' : '<a href="http://www.nissanac.com.au/images/incentives/images/pdf/' . $tmp['pdf'] . '" target="_blank">') . '
								<img src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '" class="img-responsive">
								' . (empty($tmp['pdf']) ? '' : '</a>') . '</div>';
            $thumb.='<li> <a id="carousel-selector-' . $count . '" ' . ($count==1 ? 'class="selected"' : '') . ' >
									<img src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '" width="120" class="img-responsive">
								</a> </li>';
        }

        if ($current=='')
        {
            $current.='<div class="active item" data-slide-number="0">
								<img src="http://www.nissanac.com.au/images/incentives/images/comingsoon.png" class="img-responsive"></div>';
            $thumb.='<li> <a id="carousel-selector-1" class="selected" >
									<img src="http://www.nissanac.com.au/images/incentives/images/comingsoon.png" width="120" class="img-responsive"> </a> </li>';
        }

        $incentivesFinished = Incentives::Load(Incentives::FINISHED);

        if($incentivesFinished){
            $count=0;
            foreach ($incentivesFinished as $tmp) {
                $count++;
                $finished.='<div class="col-md-4">
									' . (empty($tmp['pdf']) ? '' : '<a href="http://www.nissanac.com.au/images/incentives/images/pdf/' . $tmp['pdf'] . '" target="_blank">') . '
									<img  class="img-responsive" src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '"  alt=""/>
									' . (empty($tmp['pdf']) ? '' : '</a>') . '
									<p>' . $tmp['title'] . '<br>
									' . date("d-M-Y", strtotime($tmp['start'])) . ' to ' . date("d-M-Y", strtotime($tmp['finish'])) . '</p><br>
								</div>' . ($count % 3 ? '' : '<div class="row"></div>');
            }
        }

        $incentivesPast = Incentives::Load(Incentives::PAST);
        if ($incentivesPast)
        {
            $count=0;
            foreach($incentivesPast as $tmp)
            {
                $count++;
                $past.='<div class="col-md-4">
									' . (empty($tmp['pdf']) ? '' : '<a href="http://www.nissanac.com.au/images/incentives/images/pdf/' . $tmp['pdf'] . '" target="_blank">') . '
									<img  class="img-responsive" src="http://www.nissanac.com.au/images/incentives/images/' . $tmp['image'] . '"  alt=""/>
									' . (empty($tmp['pdf']) ? '' : '</a>') . '
									<p>' . $tmp['title'] . '<br>
									' . date("d-M-Y", strtotime($tmp['start'])) . ' to ' . date("d-M-Y", strtotime($tmp['finish'])) . '</p><br>
								</div>' . ($count % 3 ? '' : '<div class="row"></div>');
            }
        }

        $this->dataForView['status'] = $status;
        $this->dataForView['current'] = $current;
        $this->dataForView['thumb'] = $thumb;
        $this->dataForView['finished'] = $finished;
        $this->dataForView['past'] = $past;
        $this->dataForView['registered'] = $this->userObject->registered === 'YES';

        $this->render('dashboard/incentives');
    }

    /**
     * Load account page
     */
    public function account(){
        $this->dataForView['user'] = $this->userObject;
        $this->render('dashboard/account');
        return;
    }

    /**
     * Load calendar view
     */
    public function calendar(){
        $nissanEvents = Events::Load();
        $eventsJsObjectString = '';
        if($nissanEvents){
            foreach ($nissanEvents as $evt) {
                $eventsJsObjectString .= '{
                    id: ' . $evt['id'] . ',
                    name: \'' . $evt['title'] . '\',
                    startDate: new Date(' . date("Y",strtotime($evt['datestamp'])) . ', ' . (date("m",strtotime($evt['datestamp']))-1) . ', ' . (date("d",strtotime($evt['datestamp']))*1) . '),
                    endDate: new Date(' . date("Y",strtotime($evt['dateend'])) . ', ' . (date("m",strtotime($evt['dateend']))-1) . ', ' . (date("d",strtotime($evt['dateend']))*1) . ')
                },';
            }
        }
        $this->dataForView['eventsJsObjectString'] = '['.$eventsJsObjectString.']';
        $this->dataForView['extra_css'] = [
            asset('/includes/calendar/bootstrap-year-calendar.min.css'),
            asset('/includes/calendar/bootstrap-theme.min.css'),
        ];
        $this->dataForView['extra_js'] = [
            asset('/includes/calendar/bootstrap-year-calendar.min.js')
        ];

        $this->render('dashboard/calendar');
        return;
    }
}