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
    /**
     * Load md_guide_members view
     */
    public function md_guide_members(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_members');
        return;
    }
    /**
     * Load md_guide_high_achievers view
     */
    public function md_guide_high_achievers(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_high_achievers');
        return;
    }
    /**
     * Load md_guide_high_achievers_winners view
     */
    public function md_guide_high_achievers_winners(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_high_achievers_winners');
        return;
    }
    /**
     * Load md_guide_events view
     */
    public function md_guide_events(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_events');
        return;
    }
    /**
     * Load md_guide_events_past view
     */
    public function md_guide_events_past(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_events_past');
        return;
    }

    /**
     * Load md_guide_events_high_achievers view
     */
    public function md_guide_events_high_achievers(){
        $this->dataForView['extra_css'] = [
            asset('css/md-guild.css')
        ];
        $this->render('dashboard/static/md_guide_events_high_achievers');
        return;
    }

    /**
     * Load product challenge view
     */
    public function product_challenge(){
        $this->render('dashboard/static/product_challenge');
        return;
    }
    /**
     * Load product challenge winner view
     */
    public function product_challenge_winner(){
        $this->render('dashboard/static/product_challenge_winner');
        return;
    }
    /**
     * Load product_challenge_current_event view
     */
    public function product_challenge_current_event(){
        $this->render('dashboard/static/product_challenge_current_event');
        return;
    }
    /**
     * Load leader boards view
     */
    public function leader_boards(){
        $this->render('dashboard/static/leader_boards');
        return;
    }
}