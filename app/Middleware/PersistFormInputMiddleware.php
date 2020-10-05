<?php

namespace Base\Middleware;

use Base\Helpers\Session;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PersistFormInputMiddleware extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next) {
		Session::exists('persist') ? $this->view->getEnvironment()->addGlobal('persist', Session::get('persist')) : null;
		Session::put('persist', $request->getParams());

        return $next($request, $response);
    }
	
}
