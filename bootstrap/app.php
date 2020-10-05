<?php

use Slim\App;
use Dotenv\Dotenv;
use Base\Auth\Auth;
use Slim\Csrf\Guard;
use Base\Helpers\Hash;
use Base\View\Factory;
use Noodlehaus\Config;
use Base\Helpers\Input;
use Base\Helpers\Token;
use Base\Helpers\Select;
use Base\Plugins\Upload;
use Slim\Flash\Messages;
use Base\Helpers\Permission;
use Base\Services\Twilio\Sms;
use Slim\Views\TwigExtension;
use Base\Basket\BasketSession;
use Base\Models\Product\Product;
use Base\Storage\SessionStorage;
use Base\Services\PHPMailer\Email;
use Illuminate\Pagination\Paginator;
use Base\Services\Mail\Mailer\Mailer;
use Base\Middleware\OfflineMiddleware;
use Base\ErrorHandlers\NotFoundHandler;
use Base\Middleware\CsrfViewMiddleware;
use Base\Services\MailingList\MailChimp;
use Base\View\Extensions\DebugExtension;
use Illuminate\Database\Capsule\Manager;
use Base\Middleware\CsrfStatusMiddleware;
use Dotenv\Exception\InvalidPathException;
use Base\Services\NumberVerify\NumberVerify;
use Illuminate\Pagination\LengthAwarePaginator;

session_start();

require __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv(__DIR__ . '/../'))->load();
} catch (InvalidPathException $e) {
    // Do nothing just catch Exception
}

$app = new App([
    'settings' => [
        'displayErrorDetails' => getenv('DISPLAY_ERROR_DETAILS') === 'true',
        'determineRouteBeforeAppMiddleware' => getenv('DETERMINE_ROUTE_BEFORE_APP_MIDDLEWARE') === 'true',
        'addContentLengthHeader' => getenv('ADD_CONTENT_LENGTH_HEADER') === 'false'
    ]
]);

$container = $app->getContainer();

$container['config'] = function ($container) {
    return new Config(__DIR__ . '/../config');
};

date_default_timezone_set($container->config->get('app.timezone'));
ini_set('display_errors', $container->config->get('app.displayErrors'));

$capsule = new Manager;
$capsule->addConnection($container->config->get('database'));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$container['view'] = function ($container) {
    $view = Factory::getEngine();

    $basePath = rtrim(
        str_ireplace(
            'index.php', '', 
            $container->get('request')->getUri()->getScheme() . '://' . 
            $container->get('request')->getUri()->getHost() . 
            $container->get('request')->getUri()->getBasePath()
        )
    );

    $view->addExtension(new TwigExtension($container->get('router'), $basePath));
    $view->addExtension(new DebugExtension());
    $view->getEnvironment()->addGlobal('config', $container['config']);
    $view->getEnvironment()->addGlobal('auth', $container['auth']);
    $view->getEnvironment()->addGlobal('permission', $container['permission']);
    $view->getEnvironment()->addGlobal('basket', $container['basket']);
    $view->getEnvironment()->addGlobal('flash', $container['flash']);
    $view->getEnvironment()->addGlobal('select', $container['select']);

    return $view;
};

LengthAwarePaginator::viewFactoryResolver(function () {
    return new Factory;
});

LengthAwarePaginator::defaultView('components/pagination/pagination.php');

Paginator::currentPathResolver(function () {
    return strtok($_SERVER['REQUEST_URI'], '?') ?: '/';
});

Paginator::currentPageResolver(function () {
    return Input::get('page') ?: 1;
});

$container['auth'] = function ($container) {
    return new Auth($container);
};

$container['token'] = function ($container) {
    return new Token($container);
};

$container['permission'] = function ($container) {
    return new Permission($container);
};

$container['basket'] = function ($container) {
    return new BasketSession(
		$container['storage'], 
		$container['product']
	);
};

$container['storage'] = function ($container) {
	return new SessionStorage('cart');
};

$container['product'] = function ($container) {
    return new Product;
};

$container['flash'] = function ($container) {
    return new Messages;
};

$container['select'] = function ($container) {
    return new Select;
};

$container['hash'] = function ($container) {
    return new Hash($container);
};

$container['mailchimp'] = function ($container) {
    return new MailChimp($container);
};

$container['mail'] = function ($container) {
    $transport = (new Swift_SmtpTransport($container->config->get('mail.host'), $container->config->get('mail.port'), $container->config->get('mail.encryption')))
        ->setUsername($container->config->get('mail.username'))
        ->setPassword($container->config->get('mail.password'));

    $swift = new Swift_Mailer($transport);

    return (new Mailer($swift, $container->view))->alwaysFrom($container->config->get('mail.from.address'), $container->config->get('mail.from.name'));
};

$container['number'] = function ($container) {
    return new NumberVerify($container);
};

$container['mailer'] = function ($container) {
    return new Email($container);
};

$container['sms'] = function ($container) {
    return new Sms($container);
};

$container['upload'] = function ($container) {
    return new Upload($container);
};

$container['notFoundHandler'] = function ($container) {
    return new NotFoundHandler($container);
};
/* Un-comment this errorHandler to Activate in LIVE Environment - 500 Error - Server Not Found
$container['errorHandler'] = function ($container) {
    return new ErrorHandler($container);
};
*/
$container['csrf'] = function ($container) {
    $csrf = new Guard;
    $csrf->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute('csrf_status', false);
        return $next($request, $response);
    });
	
    return $csrf;
};

$app->add(new OfflineMiddleware($container))
    ->add(new CsrfViewMiddleware($container))
    ->add(new CsrfStatusMiddleware($container))
    ->add($container->csrf);

require __DIR__ . '/../routes/admin.php';
require __DIR__ . '/../routes/auth.php';
require __DIR__ . '/../routes/member.php';
require __DIR__ . '/../routes/web.php';
