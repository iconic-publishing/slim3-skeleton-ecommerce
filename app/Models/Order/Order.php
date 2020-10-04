<?php

namespace Base\Models\Order;

use Base\Models\User\User;
use Base\Models\Order\Payment;
use Base\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;


class Order extends Model {
	
	protected $table = 'orders';
	
    protected $fillable = [
		'order_id',
		'paid',
		'terms_accepted',
        'sub_total',
		'shipping',
		'total',
		'total_saving',
		'courier_name',
		'tracking_number',
		'tracking_number_added_on',
		'complete',
		'completed_on',
		'completed_by',
		'hash'
    ];
	
	public function user() {
		return $this->belongsTo(User::class, 'user_id');
	}
	
	public function address() {
		return $this->belongsTo(User::class, 'user_id');
	}

    public function products() {
        return $this->belongsToMany(Product::class, 'orders_products')->withPivot('quantity');
    }

    public function payment() {
        return $this->hasMany(Payment::class, 'order_id');
	}
	
}