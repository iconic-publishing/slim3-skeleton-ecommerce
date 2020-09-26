<?php

namespace Base\Services\Mail\Build\Web;

use Base\Services\Mail\Mailer\Mailable;

class Contact extends Mailable {
	
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - Website Enquiry')
            ->view('components/services/emails/web/contact.php')
            ->with([
                'data' => $this->data
            ]);
    }
	
}