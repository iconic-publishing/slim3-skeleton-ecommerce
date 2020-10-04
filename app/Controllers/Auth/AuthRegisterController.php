<?php

namespace Base\Controllers\Auth;

use Base\Helpers\Filter;
use ReCaptcha\ReCaptcha;
use Base\Models\User\User;
use Base\Models\User\UserPermission;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Base\Services\Mail\Build\Auth\Activation;

class AuthRegisterController extends BaseConstructor {
	
    public function getRegister(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/auth/register.php');
    }

    public function postRegister(ServerRequestInterface $request, ResponseInterface $response) {
        $ip = Filter::ip();

        $recaptcha = new ReCaptcha($this->config->get('recaptcha.invisible.secretKey'));
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request->getParam('g-recaptcha-response', $ip));

        if($resp->isSuccess()) {
            $identifier = $this->hash->hashed($this->config->get('auth.register'));

            $user = User::create([
                'username' => mt_rand(100000, 999999),
                'email_address' => $request->getParam('email_address'),
                'email_address_verified' => $identifier,
                'password' => $this->hash->password($request->getParam('password')),
                'active' => false,
                'locked' => true,
                'active_hash' => $identifier,
                'register_ip' => $ip
            ]);

            $user->role()->attach(3);

            $user->customer()->create([
                'title' => null,
                'first_name' => $request->getParam('first_name'),
                'last_name' => $request->getParam('last_name'),
                'phone_number' => null,
                'mobile_number' => $request->getParam('mobile_number'),
                'sms' => false,
                'gdpr' => false
            ]);

            $this->mail->to($user->email_address, $this->config->get('mail.from.name'))->send(new Activation($user, $identifier));

            /*
            Send SMS to New Registered User
            $number = $request->getParam('mobile_number');
            $body = $this->view->fetch('components/services/sms/auth/activation.php', compact('user', 'identifier'));
            $this->sms->send($number, $body);
            */

            $this->flash->addMessage('success', $this->config->get('messages.register.success'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        } else {
			$this->flash->addMessage('error', $this->config->get('messages.recaptcha.error'));
			return $response->withRedirect($this->router->pathFor('getRegister'));
		}
    }

}
