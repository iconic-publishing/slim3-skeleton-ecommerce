<?php

return [

    'company' => [
        'name' => getenv('COMPANY_NAME'),
        'phone' => getenv('COMPANY_PHONE'),
        'address1' => getenv('COMPANY_ADDRESS_1'),
        'address2' => getenv('COMPANY_ADDRESS_2'),
        'address3' => getenv('COMPANY_ADDRESS_3'),
        'address4' => getenv('COMPANY_ADDRESS_4'),
        'email' => getenv('COMPANY_EMAIL'),
        'contactFormEmail' => getenv('CONTACT_FORM_EMAIL')
    ]

];