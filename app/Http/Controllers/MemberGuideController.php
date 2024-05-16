<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MemberGuideController extends Controller
{
    public function __invoke() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = 'member_guide';
        return $this->render('pages.member_guide');
    }
}
