<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            $key = 'login_attempts:' . $request->ip();
            $attempts = Cache::get($key, 0);
            
            // Exponential backoff: 1, 2, 3, 4, 6, 10, 18 minutes
            $backoffMinutes = $this->getBackoffMinutes($attempts);
            
            return Limit::perMinutes($backoffMinutes, 5)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) use ($key, $attempts) {
                    // Increment attempts counter when rate limited
                    Cache::put($key, $attempts + 1, now()->addHours(24));
                    
                    $retryAfter = $headers['Retry-After'] ?? 60;
                    return response()->json([
                        'error' => 'Too many login attempts',
                        'message' => "Please try again in {$retryAfter} seconds"
                    ], 429);
                });
        });

        RateLimiter::for('register', function (Request $request) {
            $key = 'register_attempts:' . $request->ip();
            $attempts = Cache::get($key, 0);
            
            // Exponential backoff: 1, 2, 3, 4, 6, 10, 18 minutes
            $backoffMinutes = $this->getBackoffMinutes($attempts);
            
            return Limit::perMinutes($backoffMinutes, 3)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) use ($key, $attempts) {
                    // Increment attempts counter when rate limited
                    Cache::put($key, $attempts + 1, now()->addHours(24));
                    
                    $retryAfter = $headers['Retry-After'] ?? 60;
                    return response()->json([
                        'error' => 'Too many registration attempts',
                        'message' => "Please try again in {$retryAfter} seconds"
                    ], 429);
                });
        });
    }

    /**
     * Get backoff minutes based on attempt count
     * Sequence: 1, 2, 3, 4, 6, 10, 18,24, 30, 60 minutes
     */
    private function getBackoffMinutes(int $attempts): int
    {
        $backoffSequence = [1, 2, 3, 4, 6, 10, 18, 24, 30, 60];
        
        // Use the attempt number as index, but cap at the last value in sequence
        $index = min($attempts, count($backoffSequence) - 1);
        
        return $backoffSequence[$index];
    }
}