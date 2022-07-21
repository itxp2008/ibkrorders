<?php

namespace App\Http\Middleware;

use App\GeneralSettings;
use Closure;
use Illuminate\Http\Request;

class EnsureStatusTrue
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (!app(GeneralSettings::class)->status) {
            return redirect()->route('clientportal.status');
        }

        return $next($request);
    }
}