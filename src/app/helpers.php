<?php

use Classes\Lib\Container;
use Classes\Lib\DebugBar;
use Classes\Lib\Session;
use Illuminate\Database\Capsule\Manager;
use Slim\Http\Request;

if (!function_exists('m')) {
    function m($message) {
        Container::get("debugBar")->addMessage($message);
    }
}

if (!function_exists('session')) {
    /**
     * @return Session
     */
    function session() {
        return Container::get("session");
    }
}

if (!function_exists('request')) {
    /**
     * @return Request
     */
    function request() {
        return Container::get("request");
    }
}

if (!function_exists('DB')) {
    /**
     * Instead of DB facade.
     *
     * @return Manager
     */
    function DB() {
        return Container::get("db");
    }
}

if (!function_exists('debug_bar')) {
    function debug_bar() {
        DebugBar::embedDebugBar();
    }
}

