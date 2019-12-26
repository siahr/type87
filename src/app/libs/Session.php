<?php


namespace Classes\Lib;


use Anddye\Session\Helper;

class Session {

    private $parent;

    public function __construct(Helper $parent) {
        $this->parent = $parent;
    }

    public function __get(string $key) {
        return $this->parent->__get($key);
    }

    public function __isset(string $key) {
        return $this->parent->__isset($key);
    }

    public function __set(string $key, $value) {
        return $this->parent->__set($key, $value);
    }

    public function __unset(string $key) {
        return $this->parent->__unset($key);
    }

    public function delete(string $key): bool {
        return $this->parent->delete($key);
    }

    public function destroy() {
        $this->parent->destroy();
    }

    public function exists(string $key): bool {
        return $this->parent->exists($key);
    }

    public function get(string $key, $default = null) {
        return $this->parent->get($key, $default);
    }

    public function set(string $key, $value) {
        return $this->parent->set($key, $value);
    }

}