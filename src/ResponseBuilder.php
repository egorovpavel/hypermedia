<?php

namespace salesengineonline\hypermedia\src;


use Hyperspan\Formatter\Hal;
use Hyperspan\Response;

class ResponseBuilder
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function item($item)
    {
        $this->response->addItem('item', $item);
        return $this;
    }

    public function items($items)
    {
        $this->response->setItems('items', $items);
        return $this;
    }

    public function withSelfRel()
    {
        $this->response->addLink('self', 'link');
        return $this;
    }

    public function json()
    {
        $formatter = new Hal($this->response);
        return $formatter->toJson();
    }
}