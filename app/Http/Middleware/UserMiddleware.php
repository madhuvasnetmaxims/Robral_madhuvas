<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();

        if (!$bearerToken) {
            return response()->json([
                'data' => [],
                'message' => 'Please provide a bearer token',
                'status' => false,
            ], 401);
        }

        if (!Auth::guard('api')->check()) {
            return response()->json([
                'data' => [],
                'message' => 'Invalid bearer token',
                'status' => false,
            ], 401);
        }

        return $next($request);
    }
}
