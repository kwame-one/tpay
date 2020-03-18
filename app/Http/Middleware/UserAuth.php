<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserAuth
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
        $user = Auth::user();

        if(!$user || $user->role_id == 1)
            return response([
                'status' => 'unauthenticated',
                'message' => "invalid credentials",
                'data' => null
            ], 401);

        return $next($request);
    }
}
