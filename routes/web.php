<?php

use Base\Controllers\Web\BlogController;
use Base\Controllers\Web\ContactController;
use Base\Controllers\Web\HomeController;

$app->get('/', HomeController::class . ':index')->setName('index');

$app->group('/blog', function() {
    $this->get('', BlogController::class . ':getBlogs')->setName('getBlogs');
    $this->get('/{slug}', BlogController::class . ':getBlogDetails')->setName('getBlogDetails');
});

$app->group('/contact', function() {
    $this->get('', ContactController::class . ':contact')->setName('contact');
    $this->post('', ContactController::class . ':contactSubmit')->setName('contactSubmit');
});
