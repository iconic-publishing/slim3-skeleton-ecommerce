<?php

namespace Base\Controllers\Web;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class HomeController extends BaseConstructor {
	
    public function index(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/web/home/index.php');
    }
	
}
