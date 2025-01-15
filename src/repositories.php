<?php
declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
  $containerBuilder->addDefinitions([
    \Wanphp\Plugins\Releases\Domain\ReleasesInterface::class => \DI\autowire(\Wanphp\Plugins\Releases\Repositories\ReleasesRepository::class),
    \Wanphp\Plugins\Releases\Domain\AuthorizationHeaderInterface::class => \DI\autowire(\Wanphp\Plugins\Releases\Repositories\AuthorizationHeaderRepository::class)
  ]);
};