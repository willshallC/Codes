<?php

namespace TMS\Http\Middleware;

use Closure;

class Tl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->department_id == '4'){
            return $next($request);
        }else if ($request->user()->access_level != "4") {
            if ($request->wantsJson()) {
                return response()->json(['Message', 'You do not have access to this module.'], 403);
            }
            abort(403, 'You do not have access to this module.');
        }
        return $next($request);
    }
}
