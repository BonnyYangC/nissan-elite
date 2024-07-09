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

    public function pdf() {
        // dd(basename(public_path('files/2024/MEMBERS_GUIDE.pdf#page=5')));
        // return response()->file(storage_path('app/public/file/MEMBERS_GUIDE.pdf'));
        return response()->file(public_path('files/2024/MEMBERS_GUIDE.pdf'), ['content-type'=>'application/pdf']);
    }
}
