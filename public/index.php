<?php

// Front controller - all requests start here
declare(strict_types=1);

use Core\Application;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = Application::create(dirname(__DIR__));
$app->run();
