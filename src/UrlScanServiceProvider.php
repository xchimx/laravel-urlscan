<?php

namespace Xchimx\LaravelUrlScan;

use Illuminate\Support\ServiceProvider;

class UrlScanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/urlscan.php',
            'urlscan'
        );

        $this->app->singleton('urlscan.api_key', function () {
            $apiKey = config('urlscan.urlscan_api');

            if (empty($apiKey)) {
                throw new \RuntimeException('API key is missing or invalid.');
            }

            return $apiKey;
        });

        $this->app->bind('urlscan.user', function () {
            return new User;
        });
        $this->app->bind('urlscan.scan', function () {
            return new Scan;
        });
        $this->app->bind('urlscan.search', function () {
            return new Search;
        });
        $this->app->bind('urlscan.result', function () {
            return new Result;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/urlscan.php' => config_path('urlscan.php'),
        ], 'config');
    }
}
