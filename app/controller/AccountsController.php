<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 2:42 PM
 */

namespace App\controller;
use App\models\nissan\Events;
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