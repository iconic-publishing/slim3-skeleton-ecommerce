<?php

namespace Base\Controllers\Web\Order;

use Base\Models\Order\Order;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ShowOrderController extends BaseConstructor {
	
	public function getShowOrder(ServerRequestInterface $request, ResponseInterface $response, $args) {
		$hash = $args['hash'];
		
        $order = Order::with(['user', 'address', 'products', 'payment'])->where('hash', $hash)->first();

        if(!$order) {
            return $response->withRedirect($this->router->pathFor('getProducts'));
        }
		
		if($order->user->customer->gdpr === true) {
			$status = 'subscribed';
			$this->mailchimp->subscribe($order->user->email_address, $order->user->customer->first_name, $status);
		}
		
		$payment = $order->payment->where('failed', false)->first();

        return $this->view->render($response, 'pages/web/order/show-order.php', compact('order', 'payment'));
    }
	
}