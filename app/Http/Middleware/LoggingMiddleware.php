<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            Log::info('Request:', [
                'method' => $request->method(),
                'path' => $request->path(),
                'query' => $request->getQueryString(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            return $next($request);
        } catch(Exception $exception){
            Log::error('Exception: ' . $exception->getMessage() . 'Stack trace: ' . $exception->getTraceAsString());
            throw $exception;
        }
    }
}
