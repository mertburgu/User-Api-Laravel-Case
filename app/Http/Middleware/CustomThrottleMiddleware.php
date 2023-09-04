<?php

namespace App\Http\Middleware;
namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottleMiddleware extends ThrottleRequests
{
    public function __construct(RateLimiter $limiter)
    {
        parent::__construct($limiter);
    }

    public function handle($request, Closure $next, $maxAttempts = 30, $decayMinutes = 1)
    {
        if ($request->header('Authorization') ===  env('API_KEY')) {
            // Anahtarı olan kullanıcılar için sınırsız istek
            return $next($request);
        }

        // Anahtarı olmayan kullanıcılar için sınırlama dakikada 30 istek şeklinde.
        return parent::handle($request, $next, $maxAttempts, $decayMinutes);
    }
}
