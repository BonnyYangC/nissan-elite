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
use App\Services\EventService;
use App\Services\ServiceResolver;
use Illuminate\Http\Request;

class EventController extends Controller {

    /** @var ServiceResolver  */
    private $resolver;

    /**
     * EventController constructor.
     * @param ServiceResolver $resolver
     * @param Request $request
     */
    public function __construct(ServiceResolver $resolver, Request $request) {
        parent::__construct($request);
        $this->resolver = $resolver;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function calendars() {
        $this->dataForView['events'] = $this->resolver->eventService()->getEventsByRegion();
        return $this->render('pages.backend.content_manager.events');
    }

    /**
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function event_info(Event $event) {
        $this->dataForView['event'] = $event;
        $this->dataForView['incentives'] = $this->resolver->incentivesService()->load();
        return $this->render('pages.backend.content_manager.event_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function event_edit(Request $request) {
        $this->resolver->eventService()->updateEvent($request->input());
        return redirect('admin/calendars');

    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function event_delete(Event $event) {
        $this->resolver->eventService()->delete($event);
        return redirect()->back();

    }

}
