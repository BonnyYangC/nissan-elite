<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Determine the theme based on the domain
        $domain = str_replace('.','-', $request->getHost());
        $theme = config("themes.".$domain, config('themes.default'));
        // Set the theme in the config 
        config(['app.theme' => $theme]);

         var_dump($domain, $theme);
        // switch ($domain) {
        //     case 'domain1.com':
        //         config(['view.path' => resource_path('views/themes/domain1')]);
        //         break;

        //     case 'domain2.com':
        //         config(['view.path' => resource_path('views/themes/domain2')]);
        //         break;

        //     default:
        //         config(['view.path' => resource_path('views/themes/default')]);
        //         break;
        // }
        return $next($request);
    }
}
