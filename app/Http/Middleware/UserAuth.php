<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
                'status' => 'forbidden',
                'message' => "access denied",
                'data' => null
            ], 403);

        return $next($request);
    }
}
