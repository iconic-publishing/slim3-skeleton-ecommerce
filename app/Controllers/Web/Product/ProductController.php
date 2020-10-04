<?php

namespace Base\Controllers\Web\Product;

use Base\Models\Product\Product;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProductController extends BaseConstructor {

    public function getProducts(ServerRequestInterface $request, ResponseInterface $response) {
        $products = Product::where('live', true)->orderBy('id', 'DESC')->paginate($this->config->get('product.paginator'))->appends($request->getParams());

        return $this->view->render($response, 'pages/web/products/products.php', compact('products'));
    }

    public function getProductDetails(ServerRequestInterface $request, ResponseInterface $response, $args) {
        $slug = $args['slug'];

        $product = Product::where('live', true)->where('slug', $slug)->first();

        return $this->view->render($response, 'pages/web/products/product-details.php', compact('product'));
    }

}