<?php

namespace Base\Events;

use Base\Events\Event;
use Base\Models\Order\Order;
use Base\Basket\BasketSession;

class OrderWasCreated extends Event {
	
    public $order;
    public $basket;

    public function __construct(Order $order, BasketSession $basket) {
        $this->order = $order;
        $this->basket = $basket;
    }
	
}