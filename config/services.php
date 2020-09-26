<?php

return [

    'mail' => [
        'host' => getenv('MAIL_HOST'),
        'port' => getenv('MAIL_PORT'),
        'encryption' => getenv('MAIL_ENCRYPTION'),
        'username' => getenv('MAIL_USERNAME'),
        'password' => getenv('MAIL_PASSWORD'),
        'from' => [
            'address' => getenv('MAIL_FROM_ADDRESS'),
            'name' => getenv('MAIL_FROM_NAME')
        ]
    ],

    'twilio' => [
        'sid' => getenv('TWILIO_SID'),
        'token' => getenv('TWILIO_TOKEN'),
        'number' => getenv('TWILIO_NUMBER'),
        'companyNumber' => getenv('TWILIO_COMPANY_NUMBER')
    ],

    'recaptcha' => [
		'invisible' => [
			'siteKey' => getenv('RECAPTCHA_INVISIBLE_SITE_KEY'),
			'secretKey' => getenv('RECAPTCHA_INVISIBLE_SECRET_KEY'),
			'badge' => getenv('RECAPTCHA_INVISIBLE_BADGE')
        ],
        
		'locale' => getenv('RECAPTCHA_LOCALE', 'en')
	],

    'gmaps' => [
        'api' => getenv('GMAPS_API')
    ],

    'stripe' => [
        'secret' => getenv('STRIPE_SECRET'),
        'public' => getenv('STRIPE_PUBLIC'),
        'currency' => getenv('STRIPE_CURRENCY', 'USD')
    ],

    'mailchimp' => [
        'api' => getenv('MAILCHIMP_API'),
        'list' => [
            'server' => getenv('MAILCHIMP_LIST_SERVER'),
            'name' => getenv('MAILCHIMP_LIST_NAME')
        ],
        'gdpr' => [
            'email' => getenv('MAILCHIMP_GDRP_EMAIL'),
            'direct' => getenv('MAILCHIMP_GDRP_DIRECT'),
            'ads' => getenv('MAILCHIMP_GDRP_ADS')
        ],
        'count' => getenv('MAILCHIMP_COUNT', 10000)
    ]

];