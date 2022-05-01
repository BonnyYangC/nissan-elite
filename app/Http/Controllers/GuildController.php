<?php

namespace App\Http\Controllers;

use App\Services\GuildService;
use Illuminate\Http\Request;

class GuildController extends Controller {
    /** @var GuildService  */
    private $service;

    /**
     * GuildController constructor.
     * @param GuildService $guildService
     * @param Request $request
     */
    public function __construct(GuildService $guildService, Request $request) {
        parent::__construct($request);
        $this->service = $guildService;
    }

    /**
     * entry point
     *
     */
    public function guild() {
        $this->dataForView['menuName'] = 'guild';
        $this->dataForView['currentUri_sub'] = 'MDguild';
        return $this->render('pages.guild.the_guild');
    }

    /**
     * entry point
     *
     */
    public function guild_events() {
        $this->dataForView['menuName'] = 'guild';
        $this->dataForView['currentUri_sub'] = 'MDguild_events';
        $this->dataForView['results'] = $this->service->getEvents();
        return $this->render('pages.guild.the_events');
    }

    /**
     * entry point
     *
     */
    public function guild_members() {
        $this->dataForView['menuName'] = 'guild';
        $this->dataForView['currentUri_sub'] = 'MDguild_members';
        $this->dataForView['results'] = $this->service->getMembers();
        return $this->render('pages.guild.the_members');
    }
}
