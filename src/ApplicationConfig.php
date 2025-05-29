<?php

namespace LinkifyrApi;

use DI\Definition\Source\DefinitionArray;
use LinkifyrApi\App\Factory\LoggerFactory;
use LinkifyrApi\App\Factory\PdoFactory;
use LinkifyrApi\App\Factory\RedisFactory;
use Monolog\Logger;
use PDO;
use Redis;

use function DI\factory;

class ApplicationConfig extends DefinitionArray
{
    public function __construct()
    {
        parent::__construct($this->getConfig());
    }

    private function getConfig(): array
    {
        return [
            Logger::class => factory(LoggerFactory::class),
            PDO::class => factory(PdoFactory::class),
            Redis::class => factory(RedisFactory::class),
        ];
    }
}
