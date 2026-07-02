<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // اشتراک‌گذاری متغیرهای سراسری در تمام نماها (مثلاً منوی اعلانات نخوانده)
        View::share('siteSettings', [
            'name' => 'هنرستان هزاره صنعت',
            'phone' => config('app.school_phone', '------'),
            'email' => 'info@hazareh.ir',
        ]);
    }
}
