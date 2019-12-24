<?php

use Classes\Lib\AppCapture;
use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);

    $app->add(function ($request, $response, $next) use ($app) {
        AppCapture::createInstance($app);
        $response = $next($request, $response);
        return $response;
    });


};
