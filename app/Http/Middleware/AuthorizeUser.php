<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AuthorizeUser
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

        if(auth()->user()->isNormalUser()) {

            return $next($request);

        }

        return response()->json([
            'message' => 'access denied',
        ], Response::HTTP_FORBIDDEN);



    }
}
