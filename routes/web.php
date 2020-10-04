<?php

use Base\Middleware\StripeMiddleware;
use Base\Controllers\Web\Blog\BlogController;
use Base\Controllers\Web\Cart\CartController;
use Base\Controllers\Web\Home\HomeController;
use Base\Controllers\Web\Order\OrderController;
use Base\Controllers\Web\Contact\ContactController;
use Base\Controllers\Web\Order\ShowOrderController;
use Base\Controllers\Web\Product\ProductController;

$app->get('/', HomeController::class . ':index')->setName('index');

$app->group('/product', function() {
    $this->get('', ProductController::class . ':getProducts')->setName('getProducts');
    $this->get('/{slug}', ProductController::class . ':getProductDetails')->setName('getProductDetails');
});

$app->group('/shopping-basket', function() {
	$this->get('', CartController::class . ':getCart')->setName('getCart');
	$this->get('/{slug}/{quantity}', CartController::class . ':addToCart')->setName('addToCart');
	$this->post('/update/{slug}', CartController::class . ':updateCart')->setName('updateCart');
	$this->post('/delete/{slug}', CartController::class . ':deleteCart')->setName('deleteCart');
});

$app->group('/checkout', function() {
    $this->get('', OrderController::class . ':getOrder')->setName('getOrder');
    $this->post('/process-order', OrderController::class . ':postOrder')->setName('postOrder');
})->add(new StripeMiddleware($container));

$app->get('/order/complete/{hash}', ShowOrderController::class . ':getShowOrder')->setName('getShowOrder');

$app->group('/blog', function() {
    $this->get('', BlogController::class . ':getBlogs')->setName('getBlogs');
    $this->get('/{slug}', BlogController::class . ':getBlogDetails')->setName('getBlogDetails');
});

$app->group('/contact', function() {
    $this->get('', ContactController::class . ':getContact')->setName('getContact');
    $this->post('', ContactController::class . ':postContact')->setName('postContact');
});
