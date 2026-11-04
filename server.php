<?php

/**
 * Laravel's development server router.
 *
 * Serves existing static files (e.g. built CSS/JS in public/build) directly
 * and forwards every other request through the framework front controller.
 * Used by `php -S` when `php artisan serve` is unavailable.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Return false so the PHP built-in server serves the real file from docroot.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';
