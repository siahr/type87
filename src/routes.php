<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();
    $app->get('/[{name}]', function (Request $request, Response $response) use ($container) {
        $debugbar = $container["debugBar"];
        $container->get('logger')->info("Slim-Skeleton '/' route");
        if ($name = $request->getAttribute("name")) {
            $debugbar->addMessage("Hello " . $name . "!");
        }
        $data = [
            "debugbarRenderer" => $debugbar->getRenderer(),

        ];
        return $this->view->render($response, 'index', $data);
    });
};
