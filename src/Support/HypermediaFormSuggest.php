<?php

namespace Salesengineonline\Hypermedia\src\Support;


class HypermediaFormSuggest implements \JsonSerializable
{
    public $name;
    public $href;
    public $key = 'id';
    public $value = 'name';

    function __construct(HypermediaRel $prop)
    {
        $this->name = $prop->getName();
        $this->href = $prop->href;
    }

    public function withKey($key)
    {
        $this->key = $key;
        return $this;
    }


    public function withValue($val)
    {
        $this->value = $val;
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            $this->name => [
                'href' => $this->href,
                'key' => $this->key,
                'value' => $this->value
            ]
        ];
    }
}