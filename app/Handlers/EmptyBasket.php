<?php

namespace Base\Handlers;

use Base\Handlers\Contracts\HandlerInterface;

class EmptyBasket implements HandlerInterface {
	
    public function handle($event) {
        $event->basket->clear();
    }
	
}