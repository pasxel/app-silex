<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug'] || 500 == $code) {
        $app['monolog']->addError($e->getMessage());
    }

    switch ($code) {
        case 400:
            $message = 'Bad request.';
            break;
        case 404:
            $message = 'Page not found.';
            break;
        case 405:
            $message = 'Method not allowed.';
            break;
        default:
            $message = 'Internal Server Error.';
    }

    return new Response($message, $code);
});
