<?php

use Classes\Lib\AppCapture;

if (!function_exists('m')) {
    function m($message) {
        $debugbar = AppCapture::get("debugBar");
        $debugbar->addMessage($message);
    }
}


