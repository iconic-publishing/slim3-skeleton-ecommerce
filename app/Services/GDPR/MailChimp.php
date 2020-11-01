<?php

namespace Base\Services\GDPR;

use MailchimpMarketing\ApiClient;
use Base\Constructor\BaseConstructor;

class MailChimp extends BaseConstructor {

    public function subscribe($email, $status, $firstname, $ip) {
        $client = new ApiClient();
        $client->setConfig([
            'apiKey' => $this->config->get('mailchimp.api'),
            'server' => $this->config->get('mailchimp.server'),
        ]);

        $response = $client->lists->addListMember($this->config->get('mailchimp.list'), [
            "email_address" => $email,
            "status" => $status,
            'email_type' => 'html',
            'merge_fields' => [
                'FNAME' => $firstname
            ],
            'language' => 'English',
            'vip' => true,
            'marketing_permissions' => [
                0 => [
                    'marketing_permission_id' => $this->config->get('mailchimp.gdpr.email'),
                    'text' => 'Email',
                    'enabled' => true
                ],
                1 => [
                    'marketing_permission_id' => $this->config->get('mailchimp.gdpr.direct'),
                    'text' => 'Direct Mail',
                    'enabled' => false
                ],
                2 => [
                    'marketing_permission_id' => $this->config->get('mailchimp.gdpr.ads'),
                    'text' => 'Customized Online Advertising',
                    'enabled' => true
                ]
            ],
            'ip_opt' => $ip,
            'timestamp_opt' => date('Y-m-d H:i:s')
        ]);

        return $response;
    }
	
}