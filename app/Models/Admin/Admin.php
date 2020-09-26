<?php

namespace Base\Models\Admin;

use Base\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

	protected $table = 'admins';
	
	protected $fillable = [
		'first_name',
		'last_name',
		'mobile_number',
		'avatar'
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
		if($this->first_name && $this->last_name) {
			return "{$this->first_name} {$this->last_name}";
		}
		
		if($this->first_name) {
			return $this->first_name;
		}
		
		return null;
	}
	
}