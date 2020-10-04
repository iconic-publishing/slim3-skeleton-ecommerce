<?php

namespace Base\Handlers;

use Base\Handlers\Contracts\HandlerInterface;

class RecordSuccessfulPayment implements HandlerInterface {
	
    protected $transactionId;
	protected $name;
	protected $last4;
	protected $brand;
	protected $cvc_check;
	protected $zip_check;
	protected $zip;
	protected $funding;
	protected $status;
	protected $failure_message;
	protected $risk_level;

    public function __construct($transactionId, $name, $last4, $brand, $cvc_check, $zip_check, $zip, $funding, $status, $failure_message, $risk_level) {
        $this->transactionId = $transactionId;
		$this->name = $name;
		$this->last4 = $last4;
		$this->brand = $brand;
		$this->cvc_check = $cvc_check;
		$this->zip_check = $zip_check;
		$this->zip = $zip;
		$this->funding = $funding;
		$this->status = $status;
		$this->failure_message = $failure_message;
		$this->risk_level = $risk_level;
    }

    public function handle($event) {
        $event->order->payment()->create([
            'failed' => false,
            'transaction_id' => $this->transactionId,
			'cardholder' => ucwords(strtolower($this->name)),
			'card' => '**** **** **** ' . $this->last4,
			'brand' => $this->brand,
			'cvc_check' => ucfirst($this->cvc_check) ?: null,
			'zip_check' => ucfirst($this->zip_check) ?: null,
			'zip' => ucwords(strtoupper($this->zip)) ?: null,
			'funding' => (ucwords(strtolower($this->funding))) ?: null,
			'status' => (ucwords(strtolower($this->status))) ?: null,
			'failure_message' => ($this->failure_message) ?: null,
			'risk_level' => (ucwords(strtolower($this->risk_level))) ?: null
        ]);
    }
	
}