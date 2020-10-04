<?php

return [

    'app' => [
        'timezone' => getenv('TIMEZONE'),
        'displayErrors' => getenv('DISPLAY_ERRORS'),
        'locale' => getenv('LOCALE', 'en'),
        'onContextMenu' => 'return ' . getenv('ON_CONTEXT_MENU'),
        'autocomplete' => getenv('AUTO_COMPLETE'),
        'form' => [
            'timeout' => getenv('FORM_TIMEOUT')
        ]
    ]

];
