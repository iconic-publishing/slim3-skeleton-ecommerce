<?php

namespace Base\Services\Mail\Build\Web;

use Base\Models\Order\Order;
use Base\Services\Mail\Mailer\Mailable;

class WebOrderConfirmation extends Mailable {
	
	protected $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }
	
    public function build() {
        return $this->subject(getenv('MAIL_FROM_NAME', 'Company Name') . ' - Order Confirmation')
            ->view('components/services/emails/web/order-confirmation.php')
			->with([
                'order' => $this->order
            ]);
    }
	
}