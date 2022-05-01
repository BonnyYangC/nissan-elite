<?php

namespace App\Http\Controllers;

use App\Models\Acl;
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
        'menuName'=>null
    ];

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        //check api user
        $this->dataForView['fromApi'] = strstr($request, '/api');
        $this->dataForView['dashboardMenuOnly'] = false;  //TBD
        $this->dataForView['viewLastYear'] = false;  //TBD

        /**prepare login information which used by whole site after middleware */
        $this->middleware(function ($request, $next) {

            $currentUser = Auth::user();
            $this->dataForView['currentUser'] = $currentUser;

            //get acl
            if($this->dataForView['fromApi'])
            {
                $role = Auth::guard('api')->getRoleCode();
            }else{
                if (isset($currentUser)) {
                    $role = $currentUser->position_code;
                }
            }

            if (isset($role)) {
                $this->dataForView['acls'] = Acl::getAllByPosition($role);
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
