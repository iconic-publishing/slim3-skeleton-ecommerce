<?php

namespace Base\ErrorHandlers;

use Exception;
use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorHandler extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Exception $exception) {
        return $this->view->render($response, 'components/errors/500.php')->withStatus(500)->withHeader('Content-Type', 'text/html');
    }
	
}
