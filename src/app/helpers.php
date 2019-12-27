<?php

use Classes\Lib\Container;
use Classes\Lib\DebugBar;
use Classes\Lib\Session;

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

if (!function_exists('debug_bar')) {
    function debug_bar() {
        DebugBar::embedDebugBar();
    }
}

