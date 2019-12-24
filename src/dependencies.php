<?php

use Anddye\Session\Helper;
use Classes\Lib\DebugBar;
use DebugBar\StandardDebugBar;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Slim\App;
use Illuminate\Database\Capsule\Manager;
use Slim\Container;
use Slim\Views\Blade;
use Slim\Views\PhpRenderer;
use Dopesong\Slim\Error\Whoops as WhoopsError;

return function (App $app) {
    $container = $app->getContainer();

    $container['environment'] = function () {
        // Fix the Slim 3 subdirectory issue (#1529)
        // This fix makes it possible to run the app from localhost/slim3-app
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $_SERVER['REAL_SCRIPT_NAME'] = $scriptName;
        $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);
        return new Slim\Http\Environment($_SERVER);
    };

    // view renderer
    $container['renderer'] = function (Container $c) {
        $settings = $c->get('settings')['renderer'];
        return new PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function (Container $c) {
        $settings = $c->get('settings')['logger'];
        $logger = new Logger($settings['name']);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // Service factory for the ORM
    $container['db'] = function (Container $c) {
        $capsule = new Manager;
        $capsule->addConnection($c['settings']['db'][getenv("DB_CONNECTION")]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    };

    // PHP Debug Bar
    $container['debugBar'] = function(Container $c) {
        $debugbar = new DebugBar($c, new StandardDebugBar());
        return $debugbar;
    };

    // Slim Blade View
    $container['view'] = function (Container $c) {
        return new Blade(
            $c['settings']['renderer']['blade_template_path'],
            $c['settings']['renderer']['blade_cache_path'],
            null,
            ["debugbarRenderer" => $c['debugBar']->getRenderer(),]
        );
    };

    // Whoops
    $container['phpErrorHandler'] = $container['errorHandler'] = function(Container $c) {
        return new WhoopsError();
    };

    // Session
    $container['session'] = function(Container $c) {
        return new Helper();
    };
};
