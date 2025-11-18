<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class ApiKeyAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Handle CORS preflight requests
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200);
        }

        $apiKey = $request->header('X-API-KEY');

        // Allow public routes like register/login without API key
        $publicPaths = [
            'api/register',
            'api/login',
        ];

        if (in_array($request->path(), $publicPaths)) {
            return $next($request);
        }

        if (!$apiKey) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        // Find user by API key
        $user = User::where('api_key', $apiKey)->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        // Make this user accessible via request
        $request->merge(['user' => $user]);

        return $next($request);
    }
}