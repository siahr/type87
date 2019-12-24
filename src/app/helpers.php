<?php

use Classes\Lib\Container;

if (!function_exists('m')) {
    function m($message) {
        Container::get("debugBar")->addMessage($message);
    }
}

if (!function_exists('session')) {
    function session() {
        return Container::get("session");
    }
}


