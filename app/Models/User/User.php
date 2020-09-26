<?php

namespace Base\Models\User;

use Base\Models\User\Role;
use Base\Models\Admin\Admin;
use Base\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {
    
    use SoftDeletes;
	
    protected $dates = ['deleted_at'];
    
    protected $table = 'users';

    protected $fillable = [
        'username',
        'email_address',
        'email_address_verified',
        'password',
        'token',
        'active',
        'locked',
        'active_hash',
        'recover_hash',
        'register_ip',
        'login_ip',
		'login_time',
		'last_login_time'
    ];

    public function role() {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function customer() {
		return $this->hasOne(Customer::class, 'user_id');
	}

	public function admin() {
		return $this->hasOne(Admin::class, 'user_id');
	}

    public function activateAccount() {
		$this->update([
			'email_address_verified' => null,
			'active' => true,
            'locked' => false,
			'active_hash' => null
		]);
	}
	
	public function verifyEmail() {
		$this->update([
			'email_address_verified' => null
		]);
	}
	
	public function createLoginToken($token) {
		$this->update([
			'token' => $token
		]);
	}
	
	public function removeLoginToken() {
		$this->createLoginToken(null);
	}
	
	public function createLoginIp($ip) {
		$this->update([
			'login_ip' => $ip
		]);
	}
	
	public function removeLoginIp() {
		$this->createLoginIp(null);
	}
	
	public function createLoginTime() {
		$this->update([
			'login_time' => date('Y-m-d H:i:s')
		]);
	}
	
	public function removeLoginTime() {
		$this->update([
			'login_time' => null,
			'last_login_time' => date('Y-m-d H:i:s')
		]);
	}

}
