<?php

namespace Salesengineonline\Hypermedia\src\Support;


use App\Libs\Repo\Filters\Filter;

class HypermediaFilterBuilder
{
    private $table;
    private $name;
    private $suggests;
    private $type = 'string';

    public function __construct($name)
    {
        $this->table = $name;
    }

    public function by($name): HypermediaFilterBuilder
    {
        $this->name = $name;
        return $this;
    }

    private function getFilter()
    {
        return join('.', [$this->table, $this->name]);
    }

    public function matchExact($val): Filter
    {
        return new Filter($this->getFilter(), $val);
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
            "suggests" => $this->suggests,
            "type" => $this->type
        ], function ($prop) {
            return !is_null($prop);
        });
    }
}