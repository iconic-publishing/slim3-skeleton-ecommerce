<?php

use Base\Middleware\AuthenticatedMiddleware;
use Base\Middleware\AuthenticatedTokenMiddleware;
use Base\Controllers\Member\Dashboard\MemberController;

$app->group('/{hash}_{token}', function() {
    $this->get('/member/dashboard', MemberController::class . ':member')->setName('member');
})->add(new AuthenticatedMiddleware($container))->add(new AuthenticatedTokenMiddleware($container));
