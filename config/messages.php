<?php

return [

    'messages' => [
        'auth' => [
            'error' => 'You must be signed in to access this area.',
            'info' => 'You have been logged out as your Security Token has expired!'
        ],

        'csrf' => [
            'error' => 'Something went wrong with your submission. Please try again.'
        ],

        'recaptcha' => [
            'error' => 'Robot reCAPTCHA verification failed. Please try again.'
        ],

        'contact' => [
            'error' => 'Please complete all required fields.',
            'success' => 'Your form has been submitted successfully. We will contact you shortly.'
        ],

        'register' => [
            'error' => 'Please complete all required fields for registration.',
            'success' => 'You have been registered successfully. Please activate your account with the email we have just sent you.'
        ],

        'activate' => [
            'active' => 'Your account is already activated.',
            'problem' => 'There was a problem activating your account.',
            'success' => 'Your account was activated successfully.'
        ],

        'recover' => [
            'required' => 'Please complete all required fields.',
            'error' => 'This email account is not recognised. Have you registered?',
            'success' => 'Password recovery successfully. Please reset your password with the email we have just sent you.'
        ],

        'reset' => [
            'required' => 'Please complete all required fields.',
            'error' => 'Sorry, your credentials do not match.',
            'success' => 'Your password has been reset. You can now login.'
        ],

        'login' => [
            'error' => 'Please sign in with your credentials.',
            'notUser' => 'Could not sign you in with those details.',
            'notActive' => 'Account not activated. Please use the link in the email we have sent you.',
            'passwordReset' => 'You have requested a Password Reset. Please use the link in the email we have sent you.',
            'locked' => 'Account Locked! Please contact our Admin Dept.',
            'logout' => 'You have logged out successfully.'
        ],

        'payment' => [
			'member' => [
				'token' => 'Error! Have you supplied your Card Details?',
				'invalid' => 'Invalid input supplied!',
				'success' => 'Congratulations! Order completed successfully.'
			],
			'checkout' => [
				'token' => 'Error! Have you supplied your Card Details?',
				'invalid' => 'Invalid input supplied!',
				'success' => 'Congratulations! Your order was completed successfully.'
			],
		],
    ]
	
];
