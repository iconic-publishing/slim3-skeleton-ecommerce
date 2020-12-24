<?php

namespace Base\Controllers\Member\Dashboard;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MemberController extends BaseConstructor {
	
    public function member(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'pages/member/index.php');
    }
	
}
