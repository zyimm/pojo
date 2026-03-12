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
                continue;
            }
            $method = 'set'.to_camel_case($property);
            if (method_exists($this, $method)) {
                call_user_func([$this, $method], $value);
                $this->data[$property] = $value;
            }
        }
    }

   /**
     * 转换为 JSON 字符串
     * 
     * @param int $options JSON 编码选项（默认：UTF8 编码）
     * @return string JSON 字符串
     * @throws JsonException 当编码失败时抛出
     */
    public function toJson(int $options = JSON_UNESCAPED_UNICODE): string
    {
         // 捕获 JSON 编码错误并抛出异常
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \JsonException('JSON encode failed: ' . json_last_error_msg());
        }
        return json_encode($this->data);
    }


    /**
     * toArray
     *
     * @return array|mixed
     */
    public function toArray()
    {
        return $this->data ?? [];
    }

    /**
     * @param $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            $property = lcfirst(to_camel_case($offset));
            return $this->{$property};
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
        return property_exists($this, lcfirst(to_camel_case($offset)));
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
            $property = lcfirst(to_camel_case($offset));
            return $this->{$property} = $this->data[$offset] = $value;
        }
        return $this;
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $property          = lcfirst(to_camel_case($offset));
            $this->{$property} = null;
            unset($this->data[$offset]);
        }
    }

}
