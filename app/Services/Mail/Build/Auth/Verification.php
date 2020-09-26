<?php

namespace Base\Services\Mail\Build\Auth;

use Base\Models\User\User;
use Base\Services\Mail\Mailer\Mailable;

class Verification extends Mailable {
	
    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - Account Verification')
            ->view('components/services/emails/auth/verification.php')
            ->with([
                'user' => $this->user
            ]);
    }
	
}