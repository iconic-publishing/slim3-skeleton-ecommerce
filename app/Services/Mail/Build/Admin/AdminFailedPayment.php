<?php

namespace Base\Services\Mail\Build\Admin;

use Base\Models\Order\Order;
use Base\Services\Mail\Mailer\Mailable;

class AdminFailedPayment extends Mailable {
	
	protected $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - Customer Failed Online Payment')
            ->view('components/services/emails/admin/failed-payment.php')
			->with([
                'order' => $this->order
            ]);
    }
	
}