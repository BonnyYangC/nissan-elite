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
                $currentUser = session('mock-user');
                $this->dataForView['acls'] = [];
            } else {
                /** @var User $currentUser */
                $currentUser = Auth::user();
                $this->dataForView['acls'] = $currentUser ? Acl::getAllByPosition($currentUser->position_code) : [];

            }

            //check if specified a role
            if (!session('selected_position') && $currentUser) {
                session(['selected_position' => collect(['code' => $currentUser->position_code, 'title' => $currentUser->positions()->get($currentUser->position->code)])]);
            }
            if ($role = $request->query('asPosition')) {
                session(['selected_position' => collect(['code' => $role, 'title' => $currentUser->positions()->get($role)])]);
            }

            //var_dump(session('selected_position'));
            //if ($currentUser) var_dump($currentUser->position_code);
            
            $this->dataForView['selectedPosition'] = session('selected_position');
            $this->dataForView['currentUser'] = $currentUser;
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
