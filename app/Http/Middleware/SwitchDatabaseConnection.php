<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SwitchDatabaseConnection
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
        // Get the current theme
        $theme = config('app.theme');
        
        // You can check for different theme
        switch ($theme) {
            case '2024':
                Config::set('database.default', 'mysql_2024');
                break;
            case '2025':
                Config::set('database.default', 'mysql_2025');
                break;
            default:
                // Default to the "mysql" connection (or any default theme)
                Config::set('database.default', 'mysql');
                break;

        }

        // Purge and reconnect the database to apply the new connection
        // DB::purge('database.default');
        // DB::reconnect('database.default');

        return $next($request);
    }
}
