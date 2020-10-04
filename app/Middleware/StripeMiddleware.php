<?php

namespace Base\Middleware;

use Stripe\Stripe;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StripeMiddleware extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next) {
        $stripe = Stripe::setApiKey($this->config->get('stripe.secret'));
        
        return $next($request, $response);
    }
	
}