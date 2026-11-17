<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// When rewritten from project root .htaccess into public/, normalize SCRIPT_NAME
// so Laravel/Symfony resolves the true base URL and route path in subdirectories too.
if (
    isset($_SERVER['SCRIPT_NAME'], $_SERVER['REQUEST_URI'])
    && str_ends_with($_SERVER['SCRIPT_NAME'], '/public/index.php')
) {
    $appBase = substr($_SERVER['SCRIPT_NAME'], 0, -strlen('/public/index.php'));
    $requestPath = (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $publicPrefix = $appBase . '/public';

    if (
        $requestPath !== $publicPrefix
        && ! str_starts_with($requestPath, $publicPrefix . '/')
    ) {
        $_SERVER['SCRIPT_NAME'] = $appBase . '/index.php';
        $_SERVER['PHP_SELF'] = $appBase . '/index.php';
    }
}

$app->handleRequest(Request::capture());
