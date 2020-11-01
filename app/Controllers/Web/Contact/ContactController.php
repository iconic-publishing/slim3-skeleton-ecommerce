<?php

namespace Base\Controllers\Web\Contact;

use Base\Helpers\Filter;
use ReCaptcha\ReCaptcha;
use Base\Helpers\Session;
use PHPMailer\PHPMailer\Exception;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Base\Services\Mail\Build\Web\Contact;
use Psr\Http\Message\ServerRequestInterface;

class ContactController extends BaseConstructor {
	
    public function getContact(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/web/contact/contact.php');
    }
	
    public function postContact(ServerRequestInterface $request, ResponseInterface $response) {
        $ip = Filter::ip();

        $recaptcha = new ReCaptcha($this->config->get('recaptcha.invisible.secretKey'));
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request->getParam('g-recaptcha-response', $ip));

        if($resp->isSuccess()) {
            $data = [
                'first_name' => ucwords(strtolower($request->getParam('first_name'))),
                'last_name' => ucwords(strtolower($request->getParam('last_name'))),
                'email_address' => trim(strtolower($request->getParam('email_address'))),
                'phone_number' => $request->getParam('phone_number_valid'),
                'country' => $request->getParam('country'),
                'department' => $request->getParam('department'),
                'subject' => ucwords(strtolower($request->getParam('subject'))),
                'message' => ucfirst($request->getParam('message')),
                'gdpr' => ($request->getParam('gdpr') === 'on') ?: false
            ];

            $verify = explode(', ', $this->number->verify($request->getParam('phone_number_valid')));
            $date = date('Y-m-d H:i:s');

            /*
            Send Mail with Mailgun
            */
            $this->mail->to($this->config->get('company.contactFormEmail'), $this->config->get('mail.from.name'))->send(new Contact($data, $verify, $date, $ip));

            /*
            Send Mail with PHPMailer
            try {
                $email = $this->config->get('company.contactFormEmail');
                $fullName = '';
                $subject = 'You have a New Website Enquiry';
                $body = $this->view->fetch('components/services/emails/web/contact.php', compact('data', 'verify', 'date', 'ip'));
            } catch (Exception $e) {
                $this->flash->addMessage('error', 'Something went wrong with your submission. Please try again.');
                return $response->withRedirect($this->router->pathFor('getContact'));
            }
            */

            /*
            Send Twilio SMS here if so required
            $number = $request->getParam('mobile_number'); // If sending to User
            $number = $this->config->get('twilio.companyNumber'); // If sending to you or your company
            $body = $this->view->fetch('components/services/sms/web/contact.php', compact('data', 'verify', 'date', 'ip'));
            $this->sms->send($number, $body);
            */

            /*
            Subcribe to MailChimp here if so required
            */
            /*
            if($data['gdpr'] === true) {
                $status = 'subscribed';
                $this->mailchimp->subscribe($data['email_address'], $status, $data['first_name'], $ip);
            }
            */

            Session::delete('persist');

            $this->flash->addMessage('success', $this->config->get('messages.contact.success'));
            return $response->withRedirect($this->router->pathFor('getContact'));
        } else if($resp->getErrorCodes()) {
            $this->flash->addMessage('error', $this->config->get('messages.recaptcha.error'));
            return $response->withRedirect($this->router->pathFor('getContact'));
        }
    }
	
}
