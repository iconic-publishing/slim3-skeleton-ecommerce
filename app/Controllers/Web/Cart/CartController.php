<?php

namespace Base\Controllers\Web\Cart;

use Base\Models\Product\Product;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CartController extends BaseConstructor {

    public function getCart(ServerRequestInterface $request, ResponseInterface $response) {
        $this->basket->refresh();

        return $this->view->render($response, 'pages/web/cart/cart.php');
    }

    public function addToCart(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $slug = $args['slug'];
        $quantity = $args['quantity'];

        $product = Product::where('live', true)->where('slug', $slug)->first();

        if (!$product) {
            return $response->withRedirect($this->router->pathFor('index'));
        }

        try {
            $this->basket->add($product, $quantity);
        } catch (QuantityExceededException $e) {
            //
        }

        return $response->withRedirect($this->router->pathFor('getCart'));
    }

    public function updateCart(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $slug = $args['slug'];

        $product = Product::where('live', true)->where('slug', $slug)->first();

        if (!$product) {
            return $response->withRedirect($this->router->pathFor('index'));
        }

        try {
            $this->basket->update($product, $request->getParam('quantity'));
        } catch (QuantityExceededException $e) {
            //
        }

        return $response->withRedirect($this->router->pathFor('getCart'));
    }

    public function deleteCart(ServerRequestInterface $request, ResponseInterface $response, $args) {
		$slug = $args['slug'];
		
        $product = Product::where('slug', $slug)->first();

		if(!$this->basket->itemCount()) {
			return $response->withRedirect($this->router->pathFor('getProduct'));
		}

        try {
            $this->basket->update($product, $request->getParam('quantity'));
        } catch (QuantityExceededException $e) {
            // SET A FLASH MESSAGE IN THE SESSION
        }

		$this->flash->addMessage('error', $product->title . ' was deleted from your shopping basket.');
        return $response->withRedirect($this->router->pathFor('getCart'));
    }
    
}