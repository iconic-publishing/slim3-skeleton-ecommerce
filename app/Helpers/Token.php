<?php

namespace Base\Helpers;

use Base\Models\User\User;
use Base\Constructor\BaseConstructor;

class Token extends BaseConstructor {

    public function get() {
        return User::select('hash', 'token')->where('id', $this->auth->user()->id)->first();
    }

}