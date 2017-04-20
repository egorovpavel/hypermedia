<?php

namespace salesengineonline\hypermedia\src;


class SirenResponse
{

    protected $content;

    public function __construct()
    {

    }

    public function entity(ApiEntity $entity)
    {
        $this->content = new SirenItemResponse($entity);
        return $this;
    }

    public function entities($collection, $class)
    {
        $this->content = new SirenCollectionResponse($collection);
        return $this;
    }

    public function json()
    {
        return "";
    }
}