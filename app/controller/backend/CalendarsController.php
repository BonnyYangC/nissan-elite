<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 11/9/18
 * Time: 11:40 AM
 */

namespace App\controller\backend;

use Klein\Request;
use Klein\Response;
use App\core\BaseController;
use App\models\nissan\Events;

class CalendarsController extends BaseController
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    /**
     * Load calendars
     */
    public function calendars_index(){
        $events = Events::Load();
        $this->dataForView['events'] = array_reverse($events);
        $this->render('backend/calendar/index');
        return;
    }

    /**
     * Load calendar edit view
     */
    public function calendars_edit(){
        $event = new Events($this->request->param('eid'));
        $this->dataForView['event'] = $event;
        $this->render('backend/calendar/edit');
        return;
    }

    /**
     * Save calendar
     */
    public function calendars_save(){
        $eventData = $this->request->paramsPost()->get('event');
        $event = new Events($eventData['id']);
        foreach ($eventData as $fieldName => $value) {
            $event->$fieldName = $value;
        }
        if($event->save()){
            session_flash('msg',['content'=>$event->title.' has been updated successfully!','status'=>'success']);
        }else{
            session_flash('msg',['content'=>'System busy, please try again or contact IT person!','status'=>'danger']);
        }

        $this->response->redirect('/admin/calendars-index');
        return;
    }
}