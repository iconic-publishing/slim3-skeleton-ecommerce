<?php

namespace Base\Controllers\Auth;

use Base\Helpers\Filter;
use ReCaptcha\ReCaptcha;
use Base\Models\User\User;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Base\Services\Mail\Build\Auth\Recover;
use Psr\Http\Message\ServerRequestInterface;

class AuthRecoverPasswordController extends BaseConstructor {
	
    public function getRecoverPassword(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/auth/recover-password.php');
    }
	
    public function postRecoverPassword(ServerRequestInterface $request, ResponseInterface $response) {
        $ip = Filter::ip();
        
        $recaptcha = new ReCaptcha($this->config->get('recaptcha.invisible.secretKey'));
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request->getParam('g-recaptcha-response', $ip));

        if($resp->isSuccess()) {
            $email_address = $request->getParam('email_address');

            $user = User::where('email_address', $email_address)->first();

            if(!$user) {
                $this->flash->addMessage('error', $this->config->get('messages.recover.error'));
                return $response->withRedirect($this->router->pathFor('getRecoverPassword'));
            } else {
                $identifier = $this->hash->hashed($this->config->get('auth.recover'));

                $user->update([
                    'recover_hash' => $identifier
                ]);

                $this->mail->to($user->email_address, $this->config->get('mail.from.name'))->send(new Recover($user, $identifier));

                /*
                Send SMS to User
                $number = $user->mobile_number;
                $body = $this->view->fetch('components/services/sms/auth/recover-password.php', compact('user'));
                $this->sms->send($number, $body);
                */

                $this->flash->addMessage('success', $this->config->get('messages.recover.success'));
                return $response->withRedirect($this->router->pathFor('getLogin'));
            }
        } else {
			$this->flash->addMessage('error', $this->config->get('messages.recaptcha.error'));
			return $response->withRedirect($this->router->pathFor('getRecoverPassword'));
		}
    }

}
