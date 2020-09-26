<?php

namespace Base\Middleware;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CsrfStatusMiddleware extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next) {
        if($request->getAttribute('csrf_status') === false) {
            $this->flash->addMessage('error', $this->config->get('messages.csrf.error'));
            return $response->withRedirect($_SERVER['HTTP_REFERER']);
        }

        return $next($request, $response);
    }
	
}
