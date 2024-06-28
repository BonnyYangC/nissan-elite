<?php

namespace App\Http\Controllers;

use App\Helper\Defination;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __invoke() {
        $currentUser = Auth::user();
        $this->dataForView['currentUser'] = $currentUser;
        $this->dataForView['menuName'] = Defination::PAGE_ACCOUNT;
        return $this->render('pages.account');
    }
}
