<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $log = new Log();
        $log->ip = $request->ip();
        $log->save();

        if ($request->header('Authorization') ===  env('API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
