<?php

namespace Base\Middleware;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next) {
        if(!$this->auth->check()) {
            $this->flash->addMessage('warning', $this->config->get('messages.auth.error'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        $token = $request->getAttribute('routeInfo')[2]['token'];

        if(!$this->hash->hashCheck($this->auth->user()->token, $token)) {
            $this->auth->user()->removeLoginToken();
            $this->auth->user()->removeLoginIp();
            $this->auth->user()->removeLoginTime();
            $this->auth->logout();

            $this->flash->addMessage('warning', $this->config->get('messages.auth.info'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        return $next($request, $response);
    }
	
}
