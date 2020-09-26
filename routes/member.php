<?php

use Base\Middleware\AuthMiddleware;
use Base\Controllers\Member\MemberController;

$app->group('/member/{token}', function() {
    $this->get('/dashboard', MemberController::class . ':member')->setName('member');
})->add(new AuthMiddleware($container));