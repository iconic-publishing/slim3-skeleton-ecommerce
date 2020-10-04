<?php

namespace Base\Handlers;

use Base\Handlers\Contracts\HandlerInterface;

class MarkTermsAccepted implements HandlerInterface {
	
	protected $terms;
	
	public function __construct($terms) {
		$this->terms = $terms;
	}
	
    public function handle($event) {
        $event->order->update([
            'terms_accepted' => $this->terms
        ]);
    }
	
}