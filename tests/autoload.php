<?php

$loader = require_once __DIR__ . '/../vendor/autoload.php';
if (!($loader instanceof \Composer\Autoload\ClassLoader)) {
    $loader = new \Composer\Autoload\ClassLoader();
}

$loader->addPsr4('UnitTests\\', __DIR__ . '/unit', true);
$loader->register();
