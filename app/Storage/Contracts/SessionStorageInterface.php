<?php

namespace Base\Storage\Contracts;

interface SessionStorageInterface {
	
    public function get($index);
    public function set($index, $value);
    public function all();
    public function exists($index);
    public function remove($index);
    public function clear();
	
}