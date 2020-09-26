<?php

namespace Base\Services\Mail\Build\Auth;

use Base\Models\User\User;
use Base\Services\Mail\Mailer\Mailable;

class Recover extends Mailable {
	
    protected $user;
    protected $identifier;

    public function __construct(User $user, $identifier) {
        $this->user = $user;
        $this->identifier = $identifier;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - Password Recovery')
            ->view('components/services/emails/auth/recover-password.php')
            ->with([
                'user' => $this->user,
                'identifier' => $this->identifier
            ]);
    }
	
}