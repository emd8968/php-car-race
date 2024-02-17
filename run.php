<?php
require __DIR__ . '/vendor/autoload.php';

$GLOBALS['APPLICATION_ROOT'] = __DIR__;

$app = new \App\Application();

$app->start($argv[1] === '--live');