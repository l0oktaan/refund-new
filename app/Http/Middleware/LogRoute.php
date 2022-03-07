<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LogRoute
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
        $response = $next($request);

        if (app()->environment('local') && $request->getMethod() != 'GET') {
            $log = [
                'username' => Auth::user()->username,
                'ip' => $request->header('X-Forwarded-For') ? $request->header('X-Forwarded-For') : $request->ip(),
                'URI' => $request->getUri(),
                'METHOD' => $request->getMethod(),
                'REQUEST_BODY' => $request->all(),
                'RESPONSE' => $response->getContent()
            ];            
            Log::channel('log-route')->info(json_encode($log));
        }
        if (app()->environment('local') && $request->getMethod() == 'GET') {
            $log = [
                'username' => Auth::user()->username,
                'ip' => $request->header('X-Forwarded-For') ? $request->header('X-Forwarded-For') : $request->ip(),
                'URI' => $request->getUri(),
                'METHOD' => $request->getMethod(),
                'REQUEST_BODY' => $request->all(),
                // 'RESPONSE' => $response->getContent()
            ];            
            Log::channel('log-route')->info(json_encode($log));
        }

        return $response;
    }
}
