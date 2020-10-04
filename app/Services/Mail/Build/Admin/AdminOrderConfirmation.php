<?php

namespace Base\Services\Mail\Build\Admin;

use Base\Models\Order\Order;
use Base\Services\Mail\Mailer\Mailable;

class AdminOrderConfirmation extends Mailable {
	
	protected $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - New Online Order')
            ->view('components/services/emails/admin/order-confirmation.php')
			->with([
                'order' => $this->order
            ]);
    }
	
}