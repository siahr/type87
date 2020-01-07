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
        if (!$action) {
            $path = explode("/", $this->request->getAttribute("path"));
            $action = array_shift($path);
        }
        if (empty($action)) $action = "index";
        $className = "Classes\\Controller\\" . ucfirst(Str::camel($controller)) . "Controller";
        try {
            $reflMethod = new ReflectionMethod($className, Str::camel($action));
            $params = $reflMethod->getParameters();
            $additionalParams = [];
            $j = 0;
            for($i = 2; $i < count($params); $i++) {
                $additionalParams[] = isset($path[$j]) ? $path[$j] : null;
            }
            $args = array_merge([$this->request, $this->response], $additionalParams);
            $reflMethod->invokeArgs(new $className(Container::get()), $args);
        } catch(ReflectionException $e) {
            throw new NotFoundException($this->request, $this->response);
        }

    }
}