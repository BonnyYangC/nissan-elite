<?php

namespace App\Http\Controllers;

use App\Repositories\GuildRepository;
use Illuminate\Http\Request;

class GuildController extends Controller {
    /** @var GuildRepository  */
    private $repository;

    /**
     * GuildController constructor.
     * @param GuildRepository $guildRepo
     * @param Request $request
     */
    public function __construct(GuildRepository $guildRepo, Request $request) {
        parent::__construct($request);
        $this->repository = $guildRepo;
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
        $this->dataForView['results'] = $this->repository->getEvents();
        return $this->render('pages.guild.the_events');
    }

    /**
     * entry point
     *
     */
    public function guild_members() {
        $this->dataForView['menuName'] = 'guild';
        $this->dataForView['currentUri_sub'] = 'MDguild_members';
        $this->dataForView['results'] = $this->repository->getMembers();
        return $this->render('pages.guild.the_members');
    }
}
