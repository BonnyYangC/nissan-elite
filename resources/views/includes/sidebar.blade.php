<div class="col-xl-3 col-lg-3 col-md-3 d-sidebar d-md-block"> <!--hidden on screen small then md (exclude md)-->

     <div class="div-sidebar dp-sidebar mr-3 mt-5">
          {{--  not available until Apr 2021
          <a href="https://us1.campaign-archive.com/?e=&u=b638801141c7c48ffb9b0915a&id=aa5d0c26c6" role="button" class="btn btn-block btn-sidebar" target="_blank" style="color:red; font-weight: bold">FY20 Final Results</a>
          --}}

          @if($fromApi)
               <a href="#" role="button" class="btn btn-block btn-sidebar" onclick="event.preventDefault(); document.getElementById('back-form').submit();window.close();return false;">Back To I_ELITE</a>
          @endif

          @if(in_array(App\Models\Utils\AppConst::BUTTON_ADMIN_HOME, $acls))
               <a href="{{ route('admin.home') }}" role="button" class="btn btn-block btn-sidebar {{ isset($menuName) && $menuName=='admin_home'?'current':null }}">Admin Home</a>
          @endif
          @if(in_array(App\Models\Utils\AppConst::BUTTON_MEMBER_LIST, $acls))
               <a href="{{ route('admin.dealer_list', ['region' => App\Models\Utils\DefinationConst::REGION_ALL]) }}" role="button" class="btn btn-block btn-sidebar {{ isset($menuName) && $menuName=='dealer_list'?'current':null }}">Members List</a>
          @endif

          @if(in_array(App\Models\Utils\AppConst::BUTTON_MY_POINTS, $acls))
               <a href="{{ $fromApi ? route('api.tracking') : route('dealer.tracking') }}" role="button" class="btn btn-block btn-sidebar {{ isset($menuName) && $menuName=='tracking'?'current':null }}">My Points Tracking</a>
          @endif
          @if(in_array(App\Models\Utils\AppConst::BUTTON_MY_SUMMARY, $acls))
               <a href="{{ $fromApi ? route('api.summary_report') : route('dealer.summary_report') }}" role="button" class="btn btn-block btn-sidebar {{ isset($menuName) && $menuName=='summary_report'?'current':null }}">My Summary</a>
          @endif
          @if(in_array(App\Models\Utils\AppConst::BUTTON_MY_TEAM, $acls))
               <a target="__blank" href="{{ env('ELITE_URL', '').'/api/my-team?code='.$currentUser->dealer_code }}" role="button" class="btn btn-block btn-sidebar">My Team</a>
          @endif
          @if(in_array(App\Models\Utils\AppConst::BUTTON_CHANGE_PASSWORD, $acls))
               <a href="{{ route('change_password') }}" role="button" class="btn btn-block btn-sidebar {{ isset($menuName) && $menuName=='change_password'?'current':null }}">Change Password</a>
          @endif
          @if( $isSuperAdmin )
               <a href="{{ route('backend.home') }}" role="button" class="btn btn-block btn-sidebar">Go Backend</a>
          @endif
          @if(in_array(App\Models\Utils\AppConst::BUTTON_ADMIN_HOME, $acls))
               <a href="{{ route('admin.ielite_jump') }}" role="button" class="btn btn-block btn-sidebar">i_ELITE Individual</a>
          @endif
         @if( $isSuperAdmin )
             <a href="{{ route('admin.view_last_year') }}" role="button" class="btn btn-block btn-sidebar">FY20 Dealership</a>
         @endif
     </div>

     @if(in_array(App\Models\Utils\AppConst::PARTIAL_DEALER_INFO, $acls))
          <div class="dp-sidebar-info">
               <p>
                    <h6>Dealer Principal :</h6>{{ $currentUser->getDealerName() }}
               </p>
               <p>
                    <h6>Dealer Name :</h6>{{ $currentUser->getBusinessName() }}
                    <br>
               </p>
          </div>
     @endif
</div>
<form id="back-form" action="{{ route('logout') }}" method="POST" style="display: none;">
     @csrf
 </form>
