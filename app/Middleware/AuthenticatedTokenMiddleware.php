<?php

namespace Base\Middleware;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticatedTokenMiddleware extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next) {
        if(!$this->auth->user()) {
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        $route = $request->getAttribute('route');
        $arguments = $route->getArguments();
        $hash = $arguments['hash'];
        $token = $arguments['token'];
        $check = $hash . '_' . $token;

        if(!$this->hash->hashCheck($this->auth->user()->hash . '_' . $this->auth->user()->token, $check)) {
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