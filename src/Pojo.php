<?php

namespace Zyimm\Pojo;

use ArrayAccess;

abstract class Pojo implements ArrayAccess
{
    protected $data = [];

    public function __construct(array $data)
    {
        foreach ($data as $property => $value) {
            if (strtolower((string)$property) == 'data') {
                break;
            }
            $method = 'set'.to_camel_case($property);
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $value);
                $this->data[$property] = $value;
            }
        }
    }

    public function toJson()
    {
        return json_encode($this->data);
    }

    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$offset};
        }

        return null;
    }

    /**
     * @param $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return property_exists($this, $offset);
    }

    /**
     * @param $offset
     * @param $value
     *
     * @return Pojo
     */
    public function offsetSet($offset, $value): Pojo
    {
        if ($this->offsetExists($offset)) {
            return $this->{$offset} = $this->data[$offset] = $value;
        }
        return $this;
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->{$offset} = null;
            unset($this->data[$offset]);
        }
    }

}