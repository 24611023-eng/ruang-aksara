<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderDelivered;
use App\Listeners\AwardPointsForOrder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Suppress PHP 8.5+ deprecation warnings display
        if (function_exists('error_reporting')) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
            @ini_set('display_errors', '0');
        }
        
        // Event listeners are auto-discovered by Laravel's EventServiceProvider
        // No need for manual registration

        // Share alert threshold across all views so blades can use it for low-stock checks
        try {
            $alertThreshold = Cache::get('notification_settings.alert_threshold')
                ?? Cache::get('notification_settings', [])['alert_threshold'] ?? session('notification_settings.alert_threshold') ?? 5;
        } catch (\Exception $e) {
            $alertThreshold = 5;
        }
        View::share('alertThreshold', $alertThreshold);
    }
}
