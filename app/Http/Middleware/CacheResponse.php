<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheResponse
{
    public function handle(Request $request, Closure $next)
    {
        $key = 'response_cache:' . $request->url();

        if ($request->method() === 'GET' && Cache::has($key)) {
            return response(Cache::get($key));
        }

        $response = $next($request);

        if ($response->status() === 200) {
            Cache::put($key, $response->getContent(), now()->addMinutes(10));
        }

        return $response;
    }
}
