<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * entry point
     *
     */
    public function index()
    {

        /*if(Auth::guard('user')->check()){
            return redirect()->route('welcome');
        }
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.home');
        }
        return redirect('login');*/
        // if(Auth::check()){
            return view('home');
        // }

        //return redirect("login");
    }
}
