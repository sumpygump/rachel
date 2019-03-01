<?php

// Find where the composer autoload is
// This tool was installed as a composed dependency or directly
$root = realpath(__DIR__);
$autoloadLocations = array(
    $root . '/../../autoload.php',
    $root . '/vendor/autoload.php'
);
foreach ($autoloadLocations as $file) {
    if (file_exists($file)) {
        define('COMPOSER_AUTOLOAD', $file);
        break;
    }
}

// Composer autoload require guard
if (!defined('COMPOSER_AUTOLOAD')) {
    die(
        "You must run the command `composer install` from the terminal "
        . "in the directory '$root' before using this tool.\n"
    );
}

// Load composer autoloader
$autoload = require_once COMPOSER_AUTOLOAD;

$app = [];

$data_file = __DIR__ . "/data/catalog.json";
$catalog = new Rachel\Catalog($data_file);
$app['catalog'] = $catalog;

return $app;
