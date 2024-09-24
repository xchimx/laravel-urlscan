# About Laravel-Urlscan

This is a package for interaction with the Urlscan.io API

- [Laravel](https://laravel.com/)
- [Urlscan](https://urlscan.io/)
- [Schottstaedt](https://www.schottstaedt.net/)

## Installation
You can install the package via composer:

```bash
composer require xchimx/laravel-urlscan
```

Add the Service Provider and Facade to your ```app.php``` config file if you're not using Package Discovery.

```php
// config/app.php

'providers' => [
    ...
    Xchimx\LaravelUrlScan\UrlScanServiceProvider::class,
    ...
];

'aliases' => [
    ...
    'UrlScan' => Xchimx\LaravelUrlScan\UrlScan::class
    ...
];
```
Publish the config file using the artisan CLI tool:

```php
php artisan vendor:publish --provider="Xchimx\LaravelUrlScan\UrlScanServiceProvider"
```

finally set the [API Key](https://urlscan.io/docs/api/) in your ENV file:
```php
URLSCAN_API="YOUR-API-KEY-SET-HERE"
```

## Usage

make sure you import Urlscan
```php
use Xchimx\LaravelUrlScan\UrlScan;
```
### User
```php
$user = UrlScan::user()->getQuotas();
```
### Scan
```php
$url = 'https://laravel.com/';
$visibility = 'public'; // Options: 'public', 'private', 'unlisted'
$result = UrlScan::scan()->submitUrl($url, $visibility);
```

### Result
```php
$uuid = '358c5c79-b712-4e61-b79e-4a59e3c8b116'; //laravel.com
$getResult = UrlScan::result()->getResult($uuid);
$getScreenshot =  UrlScan::result()->getScreenshot($uuid);
```

### Search
use any search terms from [Urlscan Search Terms](https://urlscan.io/search/#*)
```php
$query = 'page.url.keyword:https\:\/\/www.paypal.com\/*';
$getSearchResults =  UrlScan::search()->search($query);
```

### Base combined example
```php
    public function startScan()
    {
        $url = 'https://laravel.com/';
        $visibility = 'public'; // Options: 'public', 'private', 'unlisted'
        $result = UrlScan::scan()->submitUrl($url, $visibility);

        if (isset($result['uuid'])) {
            sleep(10); //necessary else the scan isn't finished yet
            $getResult = UrlScan::result()->getResult($result['uuid']);
            $getScreenshot = UrlScan::result()->getScreenshot($result['uuid']);
            return [
                'result' => $getResult,
                'screenhots' => $getScreenshot
            ];

        } else {
            return response()->json(['error' => 'UUID not found'], 400);
        }
    }
```




