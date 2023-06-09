<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller {

    /** @var NewsService  */
    private $service;

    /**
     * Create a new controller instance.
     * @param NewsService $service
     * @return void
     */
    public function __construct(NewsService $service, Request $request) {
        parent::__construct($request);
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function news() {
        $this->dataForView['news'] = $this->service->load();
        return $this->render('pages.backend.content_manager.news');
    }

    /**
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function news_info(News $news) {
        $this->dataForView['news'] = $news;
        return $this->render('pages.backend.content_manager.news_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function news_edit(Request $request) {

        $this->service->updateNews($request);
        return redirect('admin/news');

    }

    /**
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function news_delete(News $news) {
        $this->service->delete($news);
        return redirect()->back();

    }
}
