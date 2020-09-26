<?php

namespace Base\View\Extensions;

use Twig_Extension;
use Twig_SimpleFunction;

class DebugExtension extends Twig_Extension {
	
    public function getFunctions() {
        return [
            new Twig_SimpleFunction('dump', [$this, 'dump'])
        ];
    }

    public function dump($var) {
        return dump($var);
    }
	
}
