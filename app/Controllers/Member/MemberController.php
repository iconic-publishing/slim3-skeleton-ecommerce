<?php

namespace Base\Controllers\Member;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MemberController extends BaseConstructor {
	
    public function member(ServerRequestInterface $request, ResponseInterface $response) {
        $token = $this->token->get();

        return $this->view->render($response, 'pages/member/index.php', compact('token'));
    }
	
}
