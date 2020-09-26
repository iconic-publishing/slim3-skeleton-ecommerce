<?php

namespace Base\ErrorHandlers;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundHandler extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) {
        return $this->view->render($response, 'components/errors/404.php')->withStatus(404)->withHeader('Content-Type', 'text/html');
    }
	
}
