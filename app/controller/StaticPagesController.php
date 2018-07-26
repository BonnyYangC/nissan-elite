<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 12:25 PM
 */

namespace App\controller;
use Klein\Request;
use Klein\Response;

/**
 * This controller is for load static page's view
 * Class StaticPagesController
 * @package App\controller
 */
class StaticPagesController extends DashboardController
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
     * Load members guide view
     */
    public function members_guide(){
        $this->render('dashboard/static/members_guide');
        return;
    }

    /**
     * Load FAQ view
     */
    public function faq(){
        $this->render('dashboard/static/faq');
        return;
    }

    /**
     * Load md guide view
     */
    public function md_guide(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide');
        return;
    }

    public function md_guide_members(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_members');
        return;
    }

    public function md_guide_high_achievers(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_high_achievers');
        return;
    }

    public function md_guide_high_achievers_winners(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_high_achievers_winners');
        return;
    }

    public function md_guide_events(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_events');
        return;
    }

    public function md_guide_events_past(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_events_past');
        return;
    }

    public function md_guide_events_high_achievers(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_events_high_achievers');
        return;
    }
}