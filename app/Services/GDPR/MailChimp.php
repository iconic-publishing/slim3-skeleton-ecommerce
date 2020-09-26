<?php

namespace Base\Services\MailingList;

use Base\Helpers\Filter;
use Base\Constructor\BaseConstructor;

class MailChimp extends BaseConstructor {
	
    public function subscribe($email, $firstname, $status) {
        $apikey = $this->config->get('mailchimp.api');
        $auth = base64_encode('user:' . $apikey);

        $data = [
            'apikey' => $apikey,
            'email_address' => $email,
            'email_type' => 'html',
            'status' => $status,
            'merge_fields' => [
                'FNAME' => $firstname
            ],
            'ip_opt' => Filter::ip(),
            'timestamp_opt' => date('Y-m-d H:i:s'),
            'vip' => true,
            'marketing_permissions' => [ // GDPR Complient as of May 2018
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
            ]
        ];

        $json = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->config->get('mailchimp.list.server') . $this->config->get('mailchimp.list.name') . md5(strtolower($email)));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', 
            'Authorization: Basic ' . $auth
        ]);
        curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/3.0');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, ($status == 'unsubscribed') ? 'PATCH' : 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

        return curl_exec($curl);
    }
	
}