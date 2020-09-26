<?php

namespace Base\Auth;

use Base\Helpers\Session;
use Base\Models\User\User;

class Auth {
	
    public function user() {
        return User::find(Session::get('user'));
    }

    public function check() {
        return Session::exists('user');
    }

    public function logout() {
        Session::delete('user');
    }
	
}

