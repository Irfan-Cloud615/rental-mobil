<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
   *
   * NOTE: HTTPS enforcement (and the `upgrade-insecure-requests` CSP header
   * used to silence "Mixed Active Content Blocked" errors on hosts like
   * Railway) is handled centrally by \App\Http\Middleware\ForceSecureContent,
   * which is registered in App\Http\Kernel::$middleware. Avoid calling
   * URL::forceScheme() here so that `php artisan` console commands and local
   * http:// development continue to work.
   */
  public function boot(): void
  {
    //
  }
}
