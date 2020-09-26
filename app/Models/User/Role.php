<?php

namespace Base\Models\User;

use Base\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	
	protected $table = 'roles';

    protected $fillable = [
		'role_name'
	];
	
	public function user() {
        return $this->belongsToMany(User::class, 'role_user')->withTimestamps();
    }
	
}