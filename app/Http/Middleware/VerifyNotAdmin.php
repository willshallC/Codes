<?php

namespace TMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VerifyNotAdmin
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
        if ($request->user()->access_level == "1") {
            if ($request->wantsJson()) {
                return response()->json(['Message', 'You do not have access to this module.'], 403);
            }
            abort(403, 'You do not have access to this module.');
        }else{
            if($request->user()->status == 0){
                Auth::logout();
                return redirect('login')->withErrors(['error' => 'Please ask Admin to approve your account.']);
            }
        }
        return $next($request);
    }
}
