<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Repositories\AwardsRepository;
use Illuminate\Http\Request;

class AwardsController extends Controller
{
    private $repository;

    public function __construct(AwardsRepository $repository, Request $request) {
        parent::__construct($request);
        $this->repository = $repository;
    }

    public function __invoke() {
        $this->dataForView['menuName'] = Defination::PAGE_AWARDS;
        $this->dataForView['awards'] = $this->repository->loadAll();
        return $this->render('pages.awards');
    }
}
