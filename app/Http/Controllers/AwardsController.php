<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use App\Models\AwardsType;
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
        // $this->dataForView['trophies'] = [
        //     AwardsType::PLATINUM_NATIONAL => 'awards/national_trophy.png',
        //     AwardsType::PLATINUM_STATE => 'awards/state_trophy.png'
        // ];
        return $this->render('pages.awards');
    }
}
