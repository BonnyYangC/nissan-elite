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
use App\models\role\FleetSalesConsultant;
use App\models\role\FleetSalesManager;
use App\models\role\IRole;
use App\models\role\PartsManager;
use App\models\role\PartsSalesRep;
use App\models\role\RetailSalesConsultant;
use App\models\role\SalesManager;
use App\models\role\ServiceAdviser;
use App\models\role\ServiceManager;
use App\models\role\StockController;
use App\models\User;
use Klein\Request;
use Klein\Response;

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
        $role = null;

        switch ($this->userObject->position){
            case User::FI:
                $role = new FI($this->userObject);  // Refined
                break;
            case User::FINANCE_CONTROLLER:
                $role = new FinanceController($this->userObject); // Refined
                break;
            case User::PARTS_MANAGER:
                $role = new PartsManager($this->userObject);    // Refined
                break;
            case User::RETAIL_SALES_CONSULTANTS:
                $role = new RetailSalesConsultant($this->userObject);   // Refined
                break;
            case User::FLEET_SALES_CONSULTANTS:
                $role = new FleetSalesConsultant($this->userObject);
                break;
            case User::FLEET_SALES_MANAGER:
                $role = new FleetSalesManager($this->userObject);   // Refined
                break;
            case User::SALES_MANAGER:
                $role = new SalesManager($this->userObject);    // Refined
                break;
            case User::STOCK_CONTROLLER:
                $role = new StockController($this->userObject);// Refined
                break;
            case User::PARTS_SALES_REP:
                $role = new PartsSalesRep($this->userObject);// Refined
                break;
            case User::SERVICE_MANAGER:
                $role = new ServiceManager($this->userObject);
                break;
            case User::SERVICE_ADVISERS:
                $role = new ServiceAdviser($this->userObject);
                break;
            default:
                break;
        }

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
     * Prepare metrics data for service manager
     */
    private function _prepareForRetailSalesConsultant(){
        $role = new RetailSalesConsultant($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->name.'.js')
        ];
    }

    /**
     * Prepare metrics data for service manager
     */
    private function _prepareForServiceAdviser(){
        $role = new ServiceAdviser($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->name.'.js')
        ];
    }

    /**
     * Prepare metrics data for service manager
     */
    private function _prepareForServiceManager(){
        $role = new ServiceManager($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->name.'.js')
        ];
    }

    /**
     * Prepare metrics data for parts sales rep
     */
    private function _prepareForPartsSalesRep(){
        $role = new PartsSalesRep($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->name;
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->name.'.js')
        ];
    }

    /**
     * Prepare metrics data for Stock manager
     */
    private function _prepareForStockController(){
        $role = new StockController($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->getTemplateName();
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->getTemplateName().'.js')
        ];
    }

    /**
     * Prepare metrics data for Sales Manager
     */
    private function _prepareForSalesManager(){
        $role = new SalesManager($this->userObject);
        $this->dataForView['metrics'] = $role->getMetrics($this->metricsData);
        $this->dataForView['metrics_template_file_name'] = $role->getTemplateName();
        $this->dataForView['extra_js'] = [
            'https://www.gstatic.com/charts/loader.js',
            asset('js/metrics/'.$role->getTemplateName().'.js')
        ];
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
        $this->dataForView['currentUri'] = 'Incentives';
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