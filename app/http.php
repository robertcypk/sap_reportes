<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpKernel\Exception;
// use Symfony\Component\Debug\ErrorHandler;
// use Symfony\Component\Debug\ExceptionHandler;
// ExceptionHandler::register(false);
// servicio de errores
$app->error(function (\Exception $e, Request $request, $code) {
    // return new Response('Lo sentimos pero ha sucedido un error grave.');
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }

    return new Response($message);
});

//http urls +
// $app['debug'] = true;
$app->mount('/',new \Web\Index());
// $app->register(new Silex\Provider\SessionServiceProvider());
Request::enableHttpMethodParameterOverride();
$app->run();
?>