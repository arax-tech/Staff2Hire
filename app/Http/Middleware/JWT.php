<?php

namespace App\Http\Middleware;

use Closure;
use JWAuth;

class JWT
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
        if (JWTAuth::parseToken()->authenticate())
        {
            return response()->json([
                'code' => 401,
                'message' => 'Please login to Access...',
            ],401);

        }
        else
        {
            return $next($request);
            
        }
    }
}
