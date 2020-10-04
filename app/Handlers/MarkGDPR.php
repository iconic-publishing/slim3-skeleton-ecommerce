<?php

namespace Base\Handlers;

use Base\Handlers\Contracts\HandlerInterface;

class MarkGDPR implements HandlerInterface {
	
	protected $gdpr;
	
	public function __construct($gdpr) {
		$this->gdpr = $gdpr;
	}
	
    public function handle($event) {
        $event->order->user->customer->update([
            'gdpr' => $this->gdpr
        ]);
    }
    
}