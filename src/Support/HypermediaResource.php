<?php

namespace Salesengineonline\Hypermedia\src;


use guymers\proxy\ProxyFactory;
use Salesengineonline\Hypermedia\src\Support\DummyInterceptor;
use Salesengineonline\Hypermedia\src\Support\HypermediaLink;



class HypermediaResource implements \JsonSerializable
{
    public $_links;
    public $_embedded;

    public function __construct()
    {
        $this->_embedded = new \stdClass();
        $this->_links = new \stdClass();
    }

    public function setItems($resourceName, $resourceArray)
    {
        $this->_embedded->$resourceName = $resourceArray;
    }

    public function setItem(HypermediaResource $resource)
    {
        $this->_embedded = $resource;
    }

    public function addRel(HypermediaLink $link)
    {
        $name = $link->getName();
        $this->_links->$name = $link;
    }

    public function __toString()
    {
        return json_encode((object)array_filter((array)$this));
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
        return array_filter((array)$this, function ($item) {
            return !($item == null || empty($item) || count((array)$item) == 0);
        });
    }
}