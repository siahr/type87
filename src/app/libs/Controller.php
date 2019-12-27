<?php


namespace Classes\Lib;

use Exception;
use Illuminate\Database\Capsule\Manager;
use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

class Controller {

    /** @var Manager */
    private $db;

    /** @var Logger */
    private $logger;


    public function __construct(\Slim\Container $container) {
        $this->db = $container['db'];
        $this->logger = $container['logger'];
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