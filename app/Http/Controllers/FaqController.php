<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Models\Faq;
use App\Repositories\FaqRepository;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /** @var FaqRepository  */
    private $repository;

    /**
     * Create a new controller instance.
     * @param FaqRepository $repository
     * @return void
     */
    public function __construct(FaqRepository $repository, Request $request) {
        parent::__construct($request);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $this->dataForView['faqs'] = $this->repository->loadAll();
        return $this->render('pages.backend.faq.faqs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $this->repository->store($request->input());
        return redirect('admin/faqs');
    }

    /**
     * Create a new resource.
     *
     */
    public function create()
    {
        $this->dataForView['faq'] = null;
        return $this->render('pages.backend.faq.faq_edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  Faq $faq
     */
    public function show(Faq $faq)
    {
        $this->dataForView['faq'] = $faq;
        return $this->render('pages.backend.faq.faq_edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        $this->repository->update($request->input());
        return redirect('admin/faqs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Faq $faq
     */
    public function destroy(Faq $faq)
    {
        $this->repository->delete($faq);
        return redirect()->back();
    }

    /**
     * entry point
     *
     */
    public function published() {
        $this->dataForView['menuName'] = Defination::PAGE_HELP;
        $this->dataForView['faqs'] = $this->repository->loadPublished();
        return $this->render('pages.help');
    }
}
