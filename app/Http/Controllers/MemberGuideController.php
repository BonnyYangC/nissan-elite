<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberGuideController extends Controller
{
    public function __invoke() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = Defination::PAGE_MEMBER_GUIDE;
        return $this->render('pages.member_guide.index');
    }

    public function pdf(Request $request) {
        // dd($request->input());
        // dd(Storage::url('MEMBERS_GUIDE.pdf'));
        switch ($request->input('type')) {
            case 'region-staff':
                return response()->file(storage_path('app/files/ELITE_WEBSITE_HOW_TO_HEAD_OFFICE_REGION_STAFF.pdf'), ['content-type'=>'application/pdf']);
            case 'member':
                return response()->file(storage_path('app/files/ELITE_WEBSITE_HOW_TO_GUIDE_MEMBERS.pdf'), ['content-type'=>'application/pdf']);
            default:
                if ($request->input('page')) {
                    $this->dataForView['pdf_src'] = "/elite/".config('app.theme')."/MEMBERS_GUIDE.pdf#page=" . $request->input('page');
                    //dd($this->dataForView['pdf_src']);
                    return $this->render('pages.member_guide.pdf');
                } else {
                    return response()->file(storage_path('app/files/'.config('app.theme').'/MEMBERS_GUIDE.pdf'), ['content-type'=>'application/pdf']);
                }
        }
    }
}