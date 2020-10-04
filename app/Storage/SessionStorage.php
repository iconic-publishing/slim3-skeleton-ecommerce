<?php

namespace Base\Storage;

use Countable;
use Base\Storage\Contracts\SessionStorageInterface;

class SessionStorage implements SessionStorageInterface, Countable {
	
    protected $session;

    public function __construct($session = 'default') {
        if(!isset($_SESSION[$session])) {
            $_SESSION[$session] = [];
        }

        $this->session = $session;
    }

    public function set($index, $value) {
        $_SESSION[$this->session][$index] = $value;
    }

    public function get($index) {
        if(!$this->exists($index)) {
            return null;
        }

        return $_SESSION[$this->session][$index];
    }

    public function exists($index) {
        return isset($_SESSION[$this->session][$index]);
    }

    public function all() {
        return $_SESSION[$this->session];
    }

    public function remove($index) {
        if($this->exists($index)) {
            unset($_SESSION[$this->session][$index]);
        }
    }

    public function clear() {
        unset($_SESSION[$this->session]);
    }

    public function count() {
        return count($this->all());
    }
	
}