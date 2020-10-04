<?php

namespace Base\Models\Customer;

use Base\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model {

	protected $table = 'addresses';
	
	protected $fillable = [
		'address',
		'city',
		'county',
		'postcode',
		'country'
    ];
	
	public function user() {
		return $this->belongsTo(User::class, 'user_id');
	}
	
}