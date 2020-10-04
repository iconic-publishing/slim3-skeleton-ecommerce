<?php

namespace Base\Models\Order;

use Base\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
	
	protected $table = 'payments';
	
    protected $fillable = [
        'failed',
        'transaction_id',
		'cardholder',
		'card',
		'brand',
		'cvc_check',
		'zip_check',
		'zip',
		'funding',
		'status',
		'failure_message',
		'risk_level'
    ];
	
	public function order() {
		return $this->belongsTo(Order::class, 'order_id');
	}
	
}