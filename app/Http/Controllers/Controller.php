<?php

namespace App\Http\Controllers;

use App\Models\{Acl, User};
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponse;

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
        /**prepare login information which used by whole site after middleware */
        $this->middleware(function ($request, $next) {

            //check api user
            $fromApi = strpos($request->url(), '/api/');
            $this->dataForView['fromApi'] = $fromApi !== false;
            if($fromApi && $request->input('user')) {
                //keep session as mock user
                // check if fake dealer
                if(!session('fake_dealer')) {
                    return abort(401);
                }
            } else if(!$fromApi && $request->input('user')){
                //keep session as mock user
            } else
             {
                session(['mock-user' => null]);
                session(['mock' => false]);
            }
            
            if (session('mock')) {
                $this->dataForView['mock'] = true;
                $currentUser = $mockedUser = session('mock-user');
                $this->dataForView['acls'] = [];
                $position = $mockedUser->positions()->get($mockedUser->position->code); // user positions() comes from result table, when new project starts, result table is empty, so use $currentUser->position->title as backup
                $this->dataForView['selectedPosition'] = collect([
                    'code' => $mockedUser->position->code, 
                    'title' => $position ? $position : $mockedUser->position->title
                ]);
            } else {
                /** @var User $currentUser */
                $currentUser = Auth::user();
                $this->dataForView['acls'] = $currentUser ? Acl::getAllByPosition($currentUser->position->code) : [];

                //check if specified a role by asPosition
                if (!session('selected_position') && $currentUser) {
                    $position = $currentUser->positions()->get($currentUser->position->code); // user positions() comes from result table, when new project starts, result table is empty, so use $currentUser->position->title as backup
                    session(['selected_position' => collect([
                        'code' => $currentUser->position->code, 
                        'title' => $position ? $position : $currentUser->position->title
                        ])
                    ]);
                }

                if ($role = $request->query('asPosition')) {
                    session(['selected_position' => collect([
                        'code' => $role, 
                        'title' => $currentUser->positions()->get($role)
                        ])
                    ]);
                }
                $this->dataForView['selectedPosition'] = session('selected_position');
            }
            
            $this->dataForView['viewLastYear'] = session('view_last_year');
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
