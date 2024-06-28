<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use Illuminate\Support\Facades\Auth;

class MemberGuideController extends Controller
{
    public function __invoke() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = Defination::PAGE_MEMBER_GUIDE;
        return $this->render('pages.member_guide');
    }
}
