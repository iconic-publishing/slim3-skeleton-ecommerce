<?php

use Base\Middleware\AuthenticatedMiddleware;
use Base\Middleware\AuthenticatedTokenMiddleware;
use Base\Controllers\Admin\Dashboard\AdminController;

$app->group('/{hash}_{token}', function($route) {
    $route->get('/admin/dashboard', AdminController::class . ':getAdmin')->setName('getAdmin');
})->add(new AuthenticatedMiddleware($container))->add(new AuthenticatedTokenMiddleware($container));
