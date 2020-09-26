<?php

namespace Base\Constructor;

use Interop\Container\ContainerInterface;

abstract class BaseConstructor {
	
    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __get($property) {
        if($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
	
}

