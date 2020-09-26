<?php

namespace Base\Helpers;

use Base\Models\User\User;
use Base\Constructor\BaseConstructor;

class Permission extends BaseConstructor {

    public function permission() {
        $user = User::with(['role'])->where('id', $this->auth->user()->id)->first();

        foreach($user->role as $role) {
            $permission = $role;
        }

        return $permission;
    }

    public function administratorGroup() {
        if($this->permission()->id == 1) {
            return $this->permission();
        }

        return null;
    }

    public function adminGroup() {
        if($this->permission()->id == 2) {
            return $this->permission();
        }

        return null;
    }

    public function customerGroup() {
        if($this->permission()->id == 3) {
            return $this->permission();
        }

        return null;
    }

}