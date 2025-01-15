<?php
declare(strict_types=1);

use Slim\App;
use Psr\Http\Server\MiddlewareInterface as Middleware;

return function (App $app, Middleware $PermissionMiddleware, Middleware $OAuthServerMiddleware) {
  // 后台管理发布信息
  $app->get('/admin/releases', \Wanphp\Plugins\Releases\Application\Manage\ReleasesApi::class)->setArgument('basePath', $app->getBasePath())->addMiddleware($PermissionMiddleware);
  $app->post('/webhook-receiver', \Wanphp\Plugins\Releases\Application\Manage\ReleasesApi::class)->setArgument('basePath', $app->getBasePath());
};


