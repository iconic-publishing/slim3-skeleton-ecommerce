<?php

namespace Base\Services\Mail\Mailer\Contracts;

use Base\Services\Mail\Mailer\Mailer;

interface MailableInterface {
	
    public function send(Mailer $mailer);
	
}