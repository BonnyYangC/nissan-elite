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
                //keep session as mock user
            } else
             {
                session(['mock-user' => null]);
                session(['mock' => false]);
            }
            
            if (session('mock')) {
                $this->dataForView['mock'] = true;
                $currentUser = session('mock-user');
                $this->dataForView['acls'] = [];
                $position = $currentUser->positions()->get($currentUser->position->code);
                $this->dataForView['selectedPosition'] = collect(['code' => $currentUser->position_code, 'title' => $position ? $position : $currentUser->position->title]);
            } else {
                /** @var User $currentUser */
                $currentUser = Auth::user();
                $this->dataForView['acls'] = $currentUser ? Acl::getAllByPosition($currentUser->position_code) : [];

                //check if specified a role by asPosition
                if (!session('selected_position') && $currentUser) {
                    $position = $currentUser->positions()->get($currentUser->position->code);
                    var_dump("position", $position);
                    var_dump("title", $currentUser->position->title);
                    var_dump("seeeion", $position ? $position : $currentUser->position->title);
                    session(['selected_position' => collect(['code' => $currentUser->position_code, 'title' => $position ? $position : $currentUser->position->title])]);
                }

                if ($role = $request->query('asPosition')) {
                    session(['selected_position' => collect(['code' => $role, 'title' => $currentUser->positions()->get($role)])]);
                }
                $this->dataForView['selectedPosition'] = session('selected_position');

                var_dump($this->dataForView['selectedPosition']);
            }
            
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
