<?php

namespace LinkifyrApi\App\Factory;

use DI\Container;
use DI\ContainerBuilder;
use LinkifyrApi\ApplicationConfig;

class ContainerFactory
{
    public static function build(): Container
    {
        $container = new ContainerBuilder();
        $container->useAutowiring(true);
        $container->addDefinitions(new ApplicationConfig());
        return  $container->build();
    }
}
