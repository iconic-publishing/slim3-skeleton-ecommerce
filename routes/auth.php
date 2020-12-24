<?php

use Base\Controllers\Auth\AuthLoginController;
use Base\Controllers\Auth\AuthLogoutController;
use Base\Middleware\PersistFormInputMiddleware;
use Base\Controllers\Auth\AuthActivateController;
use Base\Controllers\Auth\AuthRegisterController;
use Base\Controllers\Auth\AuthResetPasswordController;
use Base\Controllers\Auth\AuthRecoverPasswordController;

$app->group('/register', function($route) {
    $route->get('', AuthRegisterController::class . ':getRegister')->setName('getRegister');
    $route->post('', AuthRegisterController::class . ':postRegister')->setName('postRegister');
})->add(new PersistFormInputMiddleware($container));

$app->group('/activatation', function($route) {
    $route->get('', AuthActivateController::class . ':activate')->setName('activate');
});

$app->group('/login', function($route) {
    $route->get('', AuthLoginController::class . ':getLogin')->setName('getLogin');
    $route->post('', AuthLoginController::class . ':postLogin')->setName('postLogin');
});

$app->get('/logout', AuthLogoutController::class . ':getLogout')->setName('getLogout');

$app->group('/recover-password', function($route) {
    $route->get('', AuthRecoverPasswordController::class . ':getRecoverPassword')->setName('getRecoverPassword');
    $route->post('', AuthRecoverPasswordController::class . ':postRecoverPassword')->setName('postRecoverPassword');
});

$app->group('/reset-password/{email_address}', function($route) {
    $route->get('', AuthResetPasswordController::class . ':getResetPassword')->setName('getResetPassword');
    $route->post('', AuthResetPasswordController::class . ':postResetPassword')->setName('postResetPassword');
});
