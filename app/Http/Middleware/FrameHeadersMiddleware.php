<?php

namespace App\Http\Middleware;

use Closure;

class FrameHeadersMiddleware
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
        //return $next($request);
        $response = $next($request);
        // $response->header('X-Frame-Options', 'ALLOW FROM https://example.com/');
        $response->header('X-Frame-Options', 'SAMEORIGIN');
        return $response;
    }
}