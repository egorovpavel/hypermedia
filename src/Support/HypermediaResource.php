<?php

namespace Salesengineonline\Hypermedia\src;


use Illuminate\Support\Facades\Request;
use Salesengineonline\Hypermedia\src\Support\HypermediaForm;
use Salesengineonline\Hypermedia\src\Support\HypermediaRel;


class HypermediaResource implements \JsonSerializable
{
    public $_links = [];
    public $_embedded = [];
    public $_forms = [];

    public function setItems($resourceName, $resourceArray)
    {
        $rel = $resourceName;
        $this->_embedded[$rel] = $resourceArray;
    }

    public function setItem(HypermediaResource $resource)
    {
        $this->_embedded = $resource;
    }

    public function addRel(HypermediaRel $link)
    {
        $name = $link->getName();
        $this->_links[$name] = $link;
    }

    public function addForm(HypermediaForm $form)
    {
        $name = $form->getName();
        $this->_forms[$name] = $form;
    }

    public function withCuries()
    {

        $this->_links['curies'] = [
            "name" => str_slug(config('app.name'), '_'),
            "href" => Request::root() . '/rels/{rel}',
            "templated" => true
        ];
        return $this;
    }

    public function forms()
    {
        return [];
    }

    public function links()
    {
        return [];
    }

    public function embedded()
    {
        return [];
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
        $this->links();
        $this->forms();
        $this->embedded();
        return array_filter([
            '_links' => $this->_links,
            '_forms' => $this->_forms,
            '_embedded' => $this->_embedded,
        ], function ($item) {
            return !($item == null || empty($item) || count((array)$item) == 0);
        });
    }
}