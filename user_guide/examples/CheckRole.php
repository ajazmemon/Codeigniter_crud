<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $routeName = $request->route()->getName();

        if (Auth::user()->can($routeName)) {
            return $next($request);
        }
        if ($request->ajax()) {
            return response('{Unauthorized}', 401);
        } 
        else
        {
            abort(403, 'Unauthorized.');
        }
    }

}
