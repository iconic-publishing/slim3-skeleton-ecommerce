<?php

namespace Base\Helpers;

use Base\Constructor\BaseConstructor;

class Hash extends BaseConstructor {

    public function password($password) {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    public function passwordCheck($password, $hash) {
        return password_verify($password, $hash);
    }

    public function hashed($size) {
        return bin2hex(random_bytes($size));
    }

    public function hashCheck($known, $user) {
        return hash_equals($known, $user);
    }
	
}
