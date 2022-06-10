<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = array_merge($request->only('email', 'password'), ['active' => 1]); // add active=1 because there are duplicate email in db, so add to filter out inactive
        if (Auth::attempt($credentials)) {
            switch (Auth::user()->position_code) {
                case 'SYSTEM ADMIN':
                    return redirect('admin/dashboard');
                default:
                    return redirect('elite_individual');
            }
        }

        return redirect("login")->withErrors('Login details are not valid');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
