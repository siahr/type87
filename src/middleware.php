<?php

use Anddye\Middleware\SessionMiddleware;
use Classes\Lib\Container;
use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);

    $app->add(new SessionMiddleware([
        'autorefresh'   => true,
        'lifetime'      => '1 hour',
    ]));

    $app->add(function ($request, $response, $next) use ($app) {
        Container::createInstance($app);
        $response = $next($request, $response);
        return $response;
    });


};
