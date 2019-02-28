<?php

// Autoloader
if (file_exists(__DIR__ . '/vendor.phar')) {
    $autoload = require_once __DIR__ . '/vendor.phar';
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    $autoload = require_once __DIR__ . '/vendor/autoload.php';
} else {
    die("Autoloader not found. Run `composer install`\n");
}

$app = [];

$data_file = __DIR__ . "/data/catalog.json";
$catalog = new Rachel\Catalog($data_file);
$app['catalog'] = $catalog;

return $app;
