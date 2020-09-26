<?php

namespace Base\Controllers\Admin;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends BaseConstructor {
	
    public function admin(ServerRequestInterface $request, ResponseInterface $response) {
        $token = $this->token->get();

        return $this->view->render($response, 'pages/admin/index.php', compact('token'));
    }
	
}

