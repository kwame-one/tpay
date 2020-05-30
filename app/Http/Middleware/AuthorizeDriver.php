<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeDriver
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

        if(auth()->user()->isDriver()) {

            return $next($request);

        }

        return response()->json([
            'message' => 'access denied',
        ], Response::HTTP_FORBIDDEN);
    }
}
