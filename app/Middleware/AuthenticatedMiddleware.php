<?php

namespace Base\Middleware;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticatedMiddleware extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next) {
        if(!$this->auth->check() || !$this->auth->user()) {
            $this->flash->addMessage('warning', $this->config->get('messages.auth.error'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        return $next($request, $response);
    }
	
}
