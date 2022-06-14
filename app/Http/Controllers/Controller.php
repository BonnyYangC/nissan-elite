<?php

namespace App\Http\Controllers;

use App\Models\{Acl, User};
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $dataForView = [
        'menuName'=>null,
        'mock' => false
    ];

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $this->dataForView['viewLastYear'] = false;  //TBD

        /**prepare login information which used by whole site after middleware */
        $this->middleware(function ($request, $next) {

            //check api user
            $fromApi = strstr($request, '/api');
            $this->dataForView['fromApi'] = $fromApi;

            if(($fromApi && $request->input('user')) || (!$fromApi && $request->input('user'))) {
                //keep session
            } else //if (!$request->input('user') && !$fromApi)
             {
                session(['mock-user' => null]);
                session(['mock' => false]);
            }
            if (session('mock')) {
                $this->dataForView['mock'] = true;
                $this->dataForView['currentUser'] = session('mock-user');
                $this->dataForView['acls'] = [];
            } else {
                /** @var User $currentUser */
                $currentUser = Auth::user();
                $this->dataForView['currentUser'] = $currentUser;
                $this->dataForView['acls'] = $currentUser ? Acl::getAllByPosition($currentUser->position_code) : [];
            }
            return $next($request);
        });
    }

    /**
     * @param $path
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function render($path){
        return view($path,$this->dataForView);
    }
}
