<?php

namespace Base\Controllers\Auth;

use Base\Models\User\User;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Base\Services\Mail\Build\Auth\Verification;

class AuthActivateController extends BaseConstructor {
	
    public function activate(ServerRequestInterface $request, ResponseInterface $response) {
        $email_address = $request->getParam('email_address');
        $identifier = $request->getParam('identifier');
        
        $user = User::where('email_address', $email_address)->where('active', false)->first();

        if(!$user) {
            $this->flash->addMessage('info', $this->config->get('messages.activate.active'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }

        if(!$user || !$this->hash->hashCheck($user->active_hash, $identifier)) {
            $this->flash->addMessage('error', $this->config->get('messages.activate.problem'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        } else {
            $user->activateAccount();

            $this->mail->to($user->email_address, $this->config->get('mail.from.name'))->send(new Verification($user));

            /*
            Send SMS to User
            */
            $number = $user->mobile_number;
            $body = $this->view->fetch('components/services/sms/auth/verification.php', compact('user', 'identifier'));
            $this->sms->send($number, $body);

            $this->flash->addMessage('success', $this->config->get('messages.activate.success'));
            return $response->withRedirect($this->router->pathFor('getLogin'));
        }
    }
	
}


