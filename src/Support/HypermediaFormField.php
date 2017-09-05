<?php

namespace Salesengineonline\Hypermedia\src\Support;


class HypermediaFormField implements \JsonSerializable
{
    private $name;
    private $required;
    private $suggests;
    private $validators = [];
    private $type = 'string';

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function required(): HypermediaFormField
    {
        $this->required = true;
        $this->validators[] = 'required';
        return $this;
    }

    public function validate($validators): HypermediaFormField
    {
        $this->validators = array_merge($this->validators, $validators);
        return $this;
    }

    public function type($type): HypermediaFormField
    {
        $this->type = $type;
        return $this;
    }

    public function suggests($rel): HypermediaFormField
    {
        $this->suggests = new HypermediaFormSuggest($rel);
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
        return array_filter([
            "name" => $this->name,
            "required" => $this->required,
            "suggests" => $this->suggests,
            "type" => $this->type
        ], function ($prop) {
            return !is_null($prop);
        });
    }
}