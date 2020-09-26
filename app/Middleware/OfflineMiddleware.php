<?php

namespace Base\Middleware;

use Base\Constructor\BaseConstructor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class OfflineMiddleware extends BaseConstructor {
	
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Callable $next) {
        $offline = getenv('OFFLINE') === 'true' ? true : false;

        if($offline) {
            $response = $response->withStatus(503)->withHeader('Retry-After', 3600);
            return $this->view->render($response, 'components/errors/offline.php');
        }

        return $next($request, $response);
    }
	
}