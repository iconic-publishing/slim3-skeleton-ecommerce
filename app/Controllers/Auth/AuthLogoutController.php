<?php

namespace Base\Controllers\Auth;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthLogoutController extends BaseConstructor {
	
    public function getLogout(ServerRequestInterface $request, ResponseInterface $response) {
        $this->auth->user()->removeLoginToken();
        $this->auth->user()->removeLoginIp();
        $this->auth->user()->removeLoginTime();
        $this->auth->logout();

        $this->flash->addMessage('warning', $this->config->get('messages.login.logout'));
        return $response->withRedirect($this->router->pathFor('getLogin'));
    }
	
}
