<?php

namespace App\Http\Middleware;

use App;
use Closure;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('lang')) {
            App::setLocale($request->lang);
        }

        return $next($request);
    }
}
