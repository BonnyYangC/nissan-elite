<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller {

    private $service;

    public function __construct(EventService $eventService, Request $request) {
        parent::__construct($request);
        $this->service = $eventService;
    }

    public function calendar() {
        $this->dataForView['menuName'] = 'calendar';
        $events = $this->service->load();
        $this->dataForView['nissanEvents'] = json_encode($events);

        return $this->render('pages.calendar');
    }

    public function index() {
        $this->dataForView['events'] = $this->service->getEventsByRegion();
        return $this->render('pages.backend.content_manager.events');
    }

    public function event_info(Event $event) {
        $this->dataForView['event'] = $event;
        $this->dataForView['incentives'] = $this->service->loadIncentives();
        return $this->render('pages.backend.content_manager.event_edit');

    }

    public function event_edit(Request $request) {
        $this->service->updateEvent($request->input());
        return redirect('admin/calendars');

    }

    public function event_delete(Event $event) {
        $this->service->delete($event);
        return redirect()->back();

    }

}
