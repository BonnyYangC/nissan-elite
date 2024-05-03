<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller {

    /** @var NewsRepository  */
    private $repository;

    /**
     * Create a new controller instance.
     * @param NewsRepository $repository
     * @return void
     */
    public function __construct(NewsRepository $repository, Request $request) {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * entry point
     *
     */
    public function news() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'incentives';
        $this->dataForView['news'] = $this->repository->load();
        return $this->render('pages.news');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index() {
        $this->dataForView['news'] = $this->repository->load();
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

        $this->repository->updateNews($request);
        return redirect('admin/news');

    }

    /**
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function news_delete(News $news) {
        $this->repository->delete($news);
        return redirect()->back();

    }
}
