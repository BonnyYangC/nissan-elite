<?php

namespace App\Http\Controllers;

class ProgramController extends Controller
{
    public function __invoke() {
        $this->dataForView['menuName'] = 'program';
        return $this->render('pages.program');
    }
}
