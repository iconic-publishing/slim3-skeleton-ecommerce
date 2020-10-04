<?php

return [
	
    'auth' => [
        'token' => getenv('AUTH_TOKEN', 32),
        'register' => getenv('AUTH_REGISTER', 32),
        'recover' => getenv('AUTH_RECOVER', 32),
        'order' => getenv('AUTH_ORDER', 32)
    ]

];