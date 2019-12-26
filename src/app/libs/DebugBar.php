<?php


namespace Classes\Lib;


use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DebugBarException;
use DebugBar\StandardDebugBar;
use DebugBar\Bridge\MonologCollector;
use Slim\Container;

class DebugBar {

    private $debugbar;

    private $renderer;

    public function __construct(Container $container, StandardDebugBar $debugbar) {
        $this->debugbar = $debugbar;
        try {
            $this->debugbar->addCollector(new MonologCollector($container['logger']));
            $pdo = new TraceablePDO($container['db']->getConnection()->getPdo());
            $debugbar->addCollector(new PDOCollector($pdo));
        } catch(DebugBarException $e) {

        }
        $this->renderer = $this->debugbar->getJavascriptRenderer();
        $this->renderer->setIncludeVendors(false);
    }

    public function addMessage($value, $key="messages") {
        $this->debugbar[$key]->addMessage($value);
    }

    public function getRenderer() {
        return $this->renderer;
    }
}