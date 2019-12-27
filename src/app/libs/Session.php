<?php


namespace Classes\Lib;


use Anddye\Session\Helper;
use Illuminate\Support\Arr;

class Session
{

    private $parent;

    public function __construct(Helper $parent)
    {
        $this->parent = $parent;

        $this->ageFlashData();
    }

    public function __get(string $key)
    {
        return $this->parent->__get($key);
    }

    public function __isset(string $key)
    {
        return $this->parent->__isset($key);
    }

    public function __set(string $key, $value)
    {
        return $this->parent->__set($key, $value);
    }

    public function __unset(string $key)
    {
        return $this->parent->__unset($key);
    }

    /**
     * Age the flash data for the session.
     *
     * @return void
     */
    public function ageFlashData()
    {
        $this->forget($this->get('_flash.old', []));

        $this->put('_flash.old', $this->get('_flash.new', []));

        $this->put('_flash.new', []);
    }

    /**
     * Remove one or many items from the session.
     *
     * @param  string|array  $keys
     * @return void
     */
    public function forget($keys)
    {
        Arr::forget($_SESSION, $keys);
    }


    public function all()
    {
        return $_SESSION;
    }

    public function delete(string $key): bool
    {
        return $this->parent->delete($key);
    }

    /**
     * Remove all of the items from the session.
     *
     * @return void
     */
    public function flush()
    {
        $_SESSION = [];
    }

    /**
     * Merge new flash keys into the new flash array.
     *
     * @param  array  $keys
     * @return void
     */
    protected function mergeNewFlashes(array $keys)
    {
        $values = array_unique(array_merge($this->get('_flash.new', []), $keys));

        $this->put('_flash.new', $values);
    }


    /**
     * Reflash all of the session flash data.
     *
     * @return void
     */
    public function reflash()
    {
        $this->mergeNewFlashes($this->get('_flash.old', []));

        $this->put('_flash.old', []);
    }

    public function destroy()
    {
        $this->parent->destroy();
    }

    public function exists(string $key): bool
    {
        return $this->parent->exists($key);
    }

    /**
     * Push a value onto a session array.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function push($key, $value)
    {
        $array = $this->get($key, []);

        $array[] = $value;

        $this->put($key, $array);
    }

    /**
     * Flash a key / value pair to the session.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function flash(string $key, $value = true)
    {
        $this->put($key, $value);

        $this->push('_flash.new', $key);

        $this->removeFromOldFlashData([$key]);
    }

    /**
     * Remove the given keys from the old flash data.
     *
     * @param  array  $keys
     * @return void
     */
    protected function removeFromOldFlashData(array $keys)
    {
        $this->put('_flash.old', array_diff($this->get('_flash.old', []), $keys));
    }

    public function get(string $key, $default = null)
    {
        return Arr::get($_SESSION, $key, $default);

    }

    /**
     * Put a key / value pair or array of key / value pairs in the session.
     *
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function put($key, $value = null)
    {
        if (!is_array($key)) {
            $key = [$key => $value];
        }

        foreach($key as $arrayKey => $arrayValue) {
            Arr::set($_SESSION, $arrayKey, $arrayValue);
        }
    }

    public function set(string $key, $value = null)
    {
        $this->put($key, $value);
    }

}