<?php


namespace Classes\Lib;

use ArrayAccess;
use Exception;
use Slim\App;

class Container implements ArrayAccess {
    /** @var Container */
    private static $instance;

    /** @var App  */
    private $app;

    /** @var Container */
    private $container;

    private function __construct(App $app) {
        $this->app = $app;
        $this->container = $app->getContainer();
    }

    public static function createInstance(App $app) {
        self::$instance = new Container($app);
    }

    public static function get($offset) {
        return self::$instance->offsetGet($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset) {
        return $this->container->offsetExists($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset) {
        return $this->container->offsetGet($offset);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function offsetSet($offset, $value) {
        throw new Exception("Protected.");
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function offsetUnset($offset) {
        throw new Exception("Protected.");
    }
}