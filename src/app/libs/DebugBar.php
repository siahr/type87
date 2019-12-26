<?php


namespace Classes\Lib;


use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DebugBarException;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use DebugBar\Bridge\MonologCollector;
use Slim\Container;

class DebugBar {

    private $debugbar;

    private static $renderer;

    /**
     *
     */
    public static function embedDebugBar() {
        if (getenv('DEBUGBAR_ENABLED') != "null" && !getenv('DEBUGBAR_ENABLED')) return;
        if (getenv('DEBUGBAR_ENABLED') == "null" && !getenv('DEBUG')) return;

        $renderer = self::getRenderer();

        echo '<style type="text/css">' . PHP_EOL;
        $renderer->dumpCssAssets();
        echo '</style>' . PHP_EOL;
        echo '<script type="text/javascript">' . PHP_EOL;
        $renderer->dumpJsAssets();
        echo '</script>' . PHP_EOL;
        echo $renderer->render();
    }

    /**
     * DebugBar constructor.
     * @param Container $container
     * @param StandardDebugBar $debugbar
     * @throws DebugBarException
     */
    public function __construct(Container $container, StandardDebugBar $debugbar) {
        $this->debugbar = $debugbar;
        $this->debugbar->addCollector(new MonologCollector($container['logger']));
        $pdo = new TraceablePDO($container['db']->getConnection()->getPdo());
        $pdoCollector = new PDOCollector($pdo);
        $pdoCollector->setRenderSqlWithParams(true, "'");
        $debugbar->addCollector($pdoCollector);
        self::$renderer = $this->debugbar->getJavascriptRenderer();
        self::$renderer->setIncludeVendors(false);
    }

    /**
     * @param $value
     * @param string $key
     */
    public function addMessage($value, $key="messages") {
        $this->debugbar[$key]->addMessage($value);
    }

    /**
     * @return JavascriptRenderer
     */
    public static function getRenderer() {
        return self::$renderer;
    }
}