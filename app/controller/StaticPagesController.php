<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 26/7/18
 * Time: 12:25 PM
 */

namespace App\controller;
use App\models\User;
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
        $this->dataForView['currentUri'] = 'MembersGuide';
        $this->render('dashboard/static/members_guide');
        return;
    }

    /**
     * Load FAQ view
     */
    public function faq(){
        $this->dataForView['currentUri'] = 'FAQ';
        $this->render('dashboard/static/faq');
        return;
    }

    /**
     * Load md guide view
     */
    public function md_guide(){
        $this->dataForView['currentUri'] = 'MDguild';
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
        $this->dataForView['currentUri'] = 'MDguild';
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
        $this->dataForView['currentUri'] = 'MDguild';
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
        $this->dataForView['currentUri'] = 'MDguild';
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
        $this->dataForView['currentUri'] = 'MDguild';
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
        $this->dataForView['currentUri'] = 'MDguild';
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
        $this->dataForView['currentUri'] = 'MDguild';
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
        $this->dataForView['currentUri'] = 'ProductChallenge';
        $this->render('dashboard/static/product_challenge');
        return;
    }
    /**
     * Load product challenge winner view
     */
    public function product_challenge_winner(){
        $this->dataForView['currentUri'] = 'ProductChallenge';
        $this->render('dashboard/static/product_challenge_winner');
        return;
    }
    /**
     * Load product_challenge_current_event view
     */
    public function product_challenge_current_event(){
        $this->dataForView['currentUri'] = 'ProductChallenge';
        $this->render('dashboard/static/product_challenge_current_event');
        return;
    }
}