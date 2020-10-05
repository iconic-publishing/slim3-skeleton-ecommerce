<?php

use Base\Middleware\PersistFormInputMiddleware;
use Base\Controllers\Auth\AuthLoginController;
use Base\Controllers\Auth\AuthLogoutController;
use Base\Controllers\Auth\AuthActivateController;
use Base\Controllers\Auth\AuthRegisterController;
use Base\Controllers\Auth\AuthResetPasswordController;
use Base\Controllers\Auth\AuthRecoverPasswordController;

$app->group('/register', function() {
    $this->get('', AuthRegisterController::class . ':getRegister')->setName('getRegister');
    $this->post('', AuthRegisterController::class . ':postRegister')->setName('postRegister');
})->add(new PersistFormInputMiddleware($container));

$app->group('/activatation', function() {
    $this->get('', AuthActivateController::class . ':getActivate')->setName('getActivate');
});

$app->group('/login', function() {
    $this->get('', AuthLoginController::class . ':getLogin')->setName('getLogin');
    $this->post('', AuthLoginController::class . ':postLogin')->setName('postLogin');
});

$app->get('/logout', AuthLogoutController::class . ':getLogout')->setName('getLogout');

$app->group('/recover-password', function() {
    $this->get('', AuthRecoverPasswordController::class . ':getRecoverPassword')->setName('getRecoverPassword');
    $this->post('', AuthRecoverPasswordController::class . ':postRecoverPassword')->setName('postRecoverPassword');
});

$app->group('/reset-password/{email_address}', function() {
    $this->get('', AuthResetPasswordController::class . ':getResetPassword')->setName('getResetPassword');
    $this->post('', AuthResetPasswordController::class . ':postResetPassword')->setName('postResetPassword');
});