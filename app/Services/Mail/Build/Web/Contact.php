<?php

namespace Base\Services\Mail\Build\Web;

use Base\Services\Mail\Mailer\Mailable;

class Contact extends Mailable {

    protected $data;
    protected $verify;
    protected $date;
    protected $ip;

    public function __construct($data, $verify, $date, $ip) {
        $this->data = $data;
        $this->verify = $verify;
        $this->date = $date;
        $this->ip = $ip;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - Website Enquiry')
            ->view('components/services/emails/web/contact.php')
            ->with([
                'data' => $this->data,
                'verify' => $this->verify,
                'date' => $this->date,
                'ip' => $this->ip
            ]);
    }
	
}