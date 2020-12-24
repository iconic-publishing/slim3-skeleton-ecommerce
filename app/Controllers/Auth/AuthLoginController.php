<?php

namespace Base\Controllers\Auth;

use Base\Helpers\Filter;
use ReCaptcha\ReCaptcha;
use Base\Helpers\Session;
use Base\Models\User\User;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthLoginController extends BaseConstructor {

    public function getLogin(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/auth/login.php');
    }

    public function postLogin(ServerRequestInterface $request, ResponseInterface $response) {
        $ip = Filter::ip();

        $recaptcha = new ReCaptcha($this->config->get('recaptcha.invisible.secretKey'));
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request->getParam('g-recaptcha-response', $ip));

        if($resp->isSuccess()) {
            $identifier = $request->getParam('email_or_username');
            $email_address = $request->getParam('email_address');
            $password = $request->getParam('password');

            $user = User::where(function($query) use ($identifier) {
                return $query->where('email_address', $identifier)->orWhere('username', $identifier);
            })->first();

            if($user->recover_hash) {
                $this->flash->addMessage('warning', $this->config->get('messages.login.passwordReset'));
                return $response->withRedirect($this->router->pathFor('getLogin'));
            }

            if(!$user || !$this->hash->passwordCheck($password, $user->password)) {
                $this->flash->addMessage('error', $this->config->get('messages.login.notUser'));
                return $response->withRedirect($this->router->pathFor('getLogin'));
            }

            if(!$user->active) {
                $this->flash->addMessage('warning', $this->config->get('messages.login.notActive'));
                return $response->withRedirect($this->router->pathFor('getLogin'));
            }

            if($user->locked) {
                $this->flash->addMessage('warning', $this->config->get('messages.login.locked'));
                return $response->withRedirect($this->router->pathFor('getLogin'));
            }

            if($user && $this->hash->passwordCheck($password, $user->password)) {
                Session::put('user', $user->id);

                $auth_hash = $this->config->get('auth.hash');
                $auth_token = $this->config->get('auth.token');
                $hash = $this->hash->hashed($auth_hash);
                $token = $this->hash->hashed($auth_token);
                $ip = Filter::ip();

                $user->createLoginToken($hash, $token);
                $user->createLoginIp($ip);
                $user->createLoginTime();

                if($this->permission->administratorGroup() || $this->permission->adminGroup()) {
                    return $response->withRedirect($this->router->pathFor('getAdmin', compact('hash', 'token')));
                } else {
                    return $response->withRedirect($this->router->pathFor('getMember', compact('hash', 'token')));
                }
            } else {
                $this->flash->addMessage('warning', $this->config->get('messages.login.notActive'));
                return $response->withRedirect($this->router->pathFor('getLogin'));
            }
        } else {
			$this->flash->addMessage('error', $this->config->get('messages.recaptcha.error'));
			return $response->withRedirect($this->router->pathFor('getLogin'));
		}
    }

}

