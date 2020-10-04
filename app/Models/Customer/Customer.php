<?php

namespace Base\Models\Customer;

use Base\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {

	protected $table = 'customers';
	
	protected $fillable = [
		'title',
		'first_name',
		'last_name',
		'phone_number',
		'mobile_number',
		'sms',
		'gdpr'
    ];
	
	public function user() {
		return $this->belongsTo(User::class, 'user_id');
	}

	public function getFirstName() {
		if($this->first_name) {
			return $this->first_name;
		}
		
		return null;
	}
	
	public function getFullName() {
		if($this->title && $this->first_name && $this->last_name) {
			return "{$this->title} {$this->first_name} {$this->last_name}";
		}
		
		if($this->first_name && $this->last_name) {
			return "{$this->first_name} {$this->last_name}";
		}
		
		return null;
	}
	
}