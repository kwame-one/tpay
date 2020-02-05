<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminAuth
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
        $auth = Auth::user();

        if(!$auth || $auth->role_id != 1) {
            Auth::logout();
            return redirect('login')->with('error', 'invalid crendetials');
        }

        return $next($request);
    }
}
