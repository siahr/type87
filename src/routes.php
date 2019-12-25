<?php

use Classes\Lib\Controller;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response) use ($container) {
        $container->get('logger')->info("Slim-Skeleton '/' route");
        if ($name = $request->getAttribute("name")) {
            m("Hello " . $name . "!");
            session()->set("name", $name);
        }
        m(session()->get("name"));
        return $this->view->render($response, 'index');
    });

    $app->get('/{controller}/[{action}]', Controller::class . ':dispatch');

};
