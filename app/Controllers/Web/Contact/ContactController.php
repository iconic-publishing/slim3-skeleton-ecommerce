<?php

namespace Base\Controllers\Web\Contact;

use Base\Helpers\Filter;
use ReCaptcha\ReCaptcha;
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
                'email_address' => $request->getParam('email_address'),
                'mobile_number' => $request->getParam('mobile_number'),
                'country' => $request->getParam('country'),
                'department' => $request->getParam('department'),
                'subject' => ucwords(strtolower($request->getParam('subject'))),
                'message' => ucfirst($request->getParam('message')),
                'gdpr' => ($request->getParam('gdpr') === 'on') ?: false
            ];

            /*
            Send Mail with Mailgun
            */
            $this->mail->to($this->config->get('company.contactFormEmail'), $this->config->get('mail.from.name'))->send(new Contact($data));

            /*
            Send Mail with PHPMailer
            try {
                $email = $this->config->get('company.contactFormEmail');
                $fullName = '';
                $subject = 'You have a New Website Enquiry';
                $body = $this->view->fetch('includes/services/emails/contact.php', compact('data'));
            } catch (Exception $e) {
                $this->flash->addMessage('error', 'Something went wrong with your submission. Please try again.');
                return $response->withRedirect($this->router->pathFor('contact'));
            }
            */

            /*
            Send Twilio SMS here if so required
            $number = $request->getParam('mobile_number'); // If sending to User
            $number = $this->config->get('twilio.companyNumber'); // If sending to you or your company
            $body = $this->view->fetch('components/services/sms/web/contact.php', compact('data'));
            $this->sms->send($number, $body);
            */

            /*
            Subcribe to MailChimp here if so required
            */
            /*
            if($data['gdpr'] === true) {
                $status = 'subscribed';
                $this->mailchimp->subscribe($data['email_address'], $data['first_name'], $status);
            }
            */

            $this->flash->addMessage('success', $this->config->get('messages.contact.success'));
            return $response->withRedirect($this->router->pathFor('getContact'));
			
        } else if($resp->getErrorCodes()) {
            $this->flash->addMessage('error', $this->config->get('messages.recaptcha.error'));
            return $response->withRedirect($this->router->pathFor('getContact'));
        }
    }
	
}
