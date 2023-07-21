<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            // if( !$request->method('post') && $request->routeIs('refresh') ) {
            //     return ResponseFormatter::error(message: $e->getMessage(), code: 401);
            // }

            return response()->json(['message' => $e->getMessage()], $e->getCode());

            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());;
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());;
        }

        return $next($request);
    }
}
