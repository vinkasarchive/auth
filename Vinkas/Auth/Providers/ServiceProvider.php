<?php

namespace Vinkas\Auth\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Vinkas;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind('vinkas.auth', function () {
          return new Auth;
      });
    }
}
