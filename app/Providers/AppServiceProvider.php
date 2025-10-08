<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\CurrencyHelper;
use Illuminate\Support\Facades\URL;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // Mendaftarkan Blade directive untuk format mata uang dengan konversi
        Blade::directive('currency', function ($expression) {
            // Memisahkan parameter untuk menambahkan parameter convertAmount = true
            $segments = explode(',', $expression);
            if (count($segments) >= 2) {
                $amount = trim($segments[0]);
                $currency = trim($segments[1]);
                return "<?php echo App\\Helpers\\CurrencyHelper::format($amount, $currency, true); ?>";
            }
            return "<?php echo App\\Helpers\\CurrencyHelper::format($expression); ?>";
        });

        // Mendaftarkan Blade directive untuk format mata uang tanpa konversi
        Blade::directive('currencyNoConvert', function ($expression) {
            // Memisahkan parameter untuk menambahkan parameter convertAmount = false
            $segments = explode(',', $expression);
            if (count($segments) >= 2) {
                $amount = trim($segments[0]);
                $currency = trim($segments[1]);
                return "<?php echo App\\Helpers\\CurrencyHelper::format($amount, $currency, false); ?>";
            }
            return "<?php echo App\\Helpers\\CurrencyHelper::format($expression, false); ?>";
        });
    }
}
