<?php


namespace Classes\Lib;


use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller {

    public function __construct(\Slim\Container $container) {
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function dispatch(Request $request, Response $response) {
        $dispatcher = new Dispatcher($request, $response);

        $dispatcher->dispatch();
    }
}