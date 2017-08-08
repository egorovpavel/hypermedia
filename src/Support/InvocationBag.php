<?php
/**
 * Created by PhpStorm.
 * User: pavel.egorov
 * Date: 08/08/2017
 * Time: 18:56
 */

namespace Salesengineonline\Hypermedia\src\Support;


class InvocationBag
{
    private $method;
    private $proxy;
    private $args;


    function __construct($proxy,$method,$args)
    {
        $this->method = $method;
        $this->proxy = $proxy;
        $this->args = $args;
    }

    /**
     * @return \ReflectionMethod
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

}