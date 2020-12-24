<?php

namespace Base\Controllers\Admin\Dashboard;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends BaseConstructor {
	
    public function admin(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/admin/index.php');
    }
	
}

