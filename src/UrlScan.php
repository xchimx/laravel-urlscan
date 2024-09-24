<?php

namespace Xchimx\LaravelUrlScan;

use Illuminate\Support\Facades\Facade;

class UrlScan extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function user()
    {
        return app('urlscan.user');
    }

    public static function result()
    {
        return app('urlscan.result');
    }

    public static function scan()
    {
        return app('urlscan.scan');
    }

    public static function search()
    {
        return app('urlscan.search');
    }
}
