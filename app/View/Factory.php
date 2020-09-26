<?php

namespace Base\View;

use Slim\Views\Twig;

class Factory {
	
    protected $view;

    public static function getEngine() {
        return new Twig(__DIR__ . '/../../resources/views', [
            'cache' => getenv('VIEW_CACHE_DISABLED') === 'true' ? false : __DIR__ . '/../../storage/views'
        ]);
    }

    public function make($view, $data = []) {
        $this->view = static::getEngine()->fetch($view, $data);

        return $this;
    }

    public function render() {
        return $this->view;
    }
	
}
