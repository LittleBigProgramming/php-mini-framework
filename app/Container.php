<?php

namespace App;

use ArrayAccess;

class Container implements ArrayAccess
{

    protected $items = [];
    protected $cache = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->offsetSet($key, $item);
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        if (!$this->has($offset)) {
            return null;
        }

        if (isset($this->cache[$offset])) {
            return $this->cache[$offset];
        }

        $item = $this->items[$offset]();

        $this->cache[$offset] = $item;

        return $item;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            unset($this->items[$offset]);
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param $offset
     * @return bool
     */
    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * @param $property
     * @return mixed|null
     */
    public function __get($property)
    {
        return $this->offsetGet($property);
    }
}
