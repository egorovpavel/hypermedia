<?php
/**
 * Created by PhpStorm.
 * User: pavel.egorov
 * Date: 07/08/2017
 * Time: 14:17
 */

namespace Salesengineonline\Hypermedia\src;


use Hyperspan\Formatter\Hal;
use Hyperspan\Response;

trait HypermediaResourceTrait
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