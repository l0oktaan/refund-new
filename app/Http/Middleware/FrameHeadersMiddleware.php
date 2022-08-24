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
        // $response->headers->set('X-Frame-Options', 'ALLOW FROM url', false);
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN',false);
        // $response->header('X-XSS-Protection', '1');

        return $response;
    }
    // public function handle($request, Closure $next)
    // {
    //     $response = $next($request);

    //     $option = 'SAMEORIGIN';

    //     // In this example, we are only allowing the third party to include the "iframe" route
    //     // It's always better to scope this to a given route / set of routes to avoid any unattended security problems
    //     if ($xframeOptions = env('X_FRAME_OPTIONS', 'SAMEORIGIN')) {
    //         if (false !== strpos($xframeOptions, 'ALLOW-FROM')) {
    //             $url = trim(str_replace('ALLOW-FROM', '', $xframeOptions));

    //             $response->header('Content-Security-Policy', 'frame-ancestors '.$url);
    //         }
    //     }

    //     $response->header('X-Frame-Options', $xframeOptions);

    //     return $response;
    // }
}
