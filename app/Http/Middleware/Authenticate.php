<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Jenssegers\Agent\Agent;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $agent = new Agent();
            if ($agent->isMobile() || $agent->isTablet()) {
                return route('mobile.login');
            } else {
                return route('login');
            }
        }
    }
}
