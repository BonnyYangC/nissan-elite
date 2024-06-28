<?php

namespace App\Http\Controllers;
use App\Helper\Defination;

class ProgramController extends Controller
{
    public function __invoke() {
        $this->dataForView['menuName'] = Defination::PAGE_PROGRAM;
        return $this->render('pages.program');
    }
}
