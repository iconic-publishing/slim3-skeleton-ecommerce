<?php

namespace Base\Handlers;

use Base\Handlers\Contracts\HandlerInterface;

class MarkOrderPaid implements HandlerInterface {
	
    public function handle($event) {
        $event->order->update([
            'paid' => true
        ]);
    }
    
	
}