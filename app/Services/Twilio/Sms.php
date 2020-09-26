<?php

namespace Base\Services\Twilio;

use Twilio\Rest\Client;
use Base\Constructor\BaseConstructor;
use Twilio\Exceptions\TwilioException;

class Sms extends BaseConstructor {
	
    public function send($number, $body) {
        $sid = $this->config->get('twilio.sid');
        $token = $this->config->get('twilio.token');

        $client = new Client($sid, $token);

        try {
            $message = $client->messages->create($number, [
                'from' => $this->config->get('twilio.number'),
                'body' => $body
            ]);

            return $message;
        } catch (TwilioException $e) {
            // Catch error if so required
            // return $e->getMessage();
        }
    }
	
}
