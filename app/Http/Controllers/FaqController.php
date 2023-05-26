<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Services\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller {

    /** @var FaqService  */
    private $service;

    /**
     * Create a new controller instance.
     * @param FaqService $faqService
     * @return void
     */
    public function __construct(FaqService $faqService, Request $request) {
        parent::__construct($request);
        $this->service = $faqService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function faqs() {
        $this->dataForView['faqs'] = $this->service->loadAll();
        return $this->render('pages.backend.content_manager.faqs');
    }

    /**
     * @param Faq $faq
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function faq_info(Faq $faq) {
        $this->dataForView['faq'] = $faq;
        return $this->render('pages.backend.content_manager.faq_edit');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function faq_edit(Request $request) {

        $this->service->update($request->input());
        return redirect('admin/faqs');

    }

    /**
     * @param Faq $faq
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function faq_delete(Faq $faq) {
        $this->service->delete($faq);
        return redirect()->back();

    }
}
