<?php


namespace Classes\Lib;


use Exception;
use Illuminate\Support\Str;
use ReflectionException;
use ReflectionMethod;
use Slim\Exception\NotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;

class Dispatcher {

    private $request;

    private $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @throws Exception
     */
    public function dispatch() {
        $controller = $this->request->getAttribute("controller");
        $action = $this->request->getAttribute("action");
        if (empty($action)) $action = "index";
        $className = "Classes\\Controller\\" . ucfirst(Str::camel($controller)) . "Controller";
        try {
            $reflMethod = new ReflectionMethod($className, Str::camel($action));
            $reflMethod->invokeArgs(new $className(Container::get()), [$this->request, $this->response]);
        } catch(ReflectionException $e) {
            throw new NotFoundException($this->request, $this->response);
        }

    }
}