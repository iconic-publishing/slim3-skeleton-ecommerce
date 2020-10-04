<?php

use Base\Middleware\AuthMiddleware;
use Base\Controllers\Admin\Dashboard\AdminController;

$app->group('/admin/{token}', function() {
    $this->get('/dashboard', AdminController::class . ':admin')->setName('admin');
})->add(new AuthMiddleware($container));