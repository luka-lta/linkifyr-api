<?php

use LinkifyrApi\App\Factory\ContainerFactory;
use LinkifyrApi\Slim\SlimFactory;

require __DIR__ . '/../vendor/autoload.php';

try {
    $container = ContainerFactory::build();
    $app = SlimFactory::create($container);
    $app->run();
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}
