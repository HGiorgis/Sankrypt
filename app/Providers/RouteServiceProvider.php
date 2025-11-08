use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

public function boot(): void
{
    $this->configureRateLimiting();

    $this->routes(function () {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    });
}

protected function configureRateLimiting(): void
{
    RateLimiter::for('api', function (Request $request) {
        // Limit based on user id if authenticated, otherwise IP
        $key = optional($request->user())->id ?: $request->ip();

        return Limit::perMinute(60)->by($key); // 60 requests per minute
    });
}
