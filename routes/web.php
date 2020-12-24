<?php

use Base\Middleware\StripeMiddleware;
use Base\Controllers\Web\Blog\BlogController;
use Base\Controllers\Web\Cart\CartController;
use Base\Controllers\Web\Home\HomeController;
use Base\Controllers\Web\Order\OrderController;
use Base\Middleware\PersistFormInputMiddleware;
use Base\Controllers\Web\Contact\ContactController;
use Base\Controllers\Web\Order\ShowOrderController;
use Base\Controllers\Web\Product\ProductController;

$app->get('/', HomeController::class . ':index')->setName('index');

$app->group('/product', function($route) {
    $route->get('', ProductController::class . ':getProducts')->setName('getProducts');
    $route->get('/{slug}', ProductController::class . ':getProductDetails')->setName('getProductDetails');
});

$app->group('/shopping-basket', function($route) {
	$route->get('', CartController::class . ':getCart')->setName('getCart');
	$route->get('/{slug}/{quantity}', CartController::class . ':addToCart')->setName('addToCart');
	$route->post('/update/{slug}', CartController::class . ':updateCart')->setName('updateCart');
	$route->post('/delete/{slug}', CartController::class . ':deleteCart')->setName('deleteCart');
});

$app->group('/checkout', function($route) {
    $route->get('', OrderController::class . ':getOrder')->setName('getOrder');
    $route->post('/process-order', OrderController::class . ':postOrder')->setName('postOrder');
})->add(new PersistFormInputMiddleware($container))->add(new StripeMiddleware($container));

$app->get('/order/complete/{hash}', ShowOrderController::class . ':getShowOrder')->setName('getShowOrder');

$app->group('/blog', function($route) {
    $route->get('', BlogController::class . ':getBlogs')->setName('getBlogs');
    $route->get('/{slug}', BlogController::class . ':getBlogDetails')->setName('getBlogDetails');
});

$app->group('/contact', function($route) {
    $route->get('', ContactController::class . ':getContact')->setName('getContact');
    $route->post('', ContactController::class . ':postContact')->setName('postContact');
})->add(new PersistFormInputMiddleware($container));
