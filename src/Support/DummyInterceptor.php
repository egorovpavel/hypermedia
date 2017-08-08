<?php

namespace Salesengineonline\Hypermedia\src\Support;


use guymers\proxy\MethodHook;
use ReflectionMethod;

class DummyInterceptor implements MethodHook
{

    /**
     * Does this hook support this method
     *
     * @param ReflectionMethod $method
     * @return boolean
     */
    public function supports(ReflectionMethod $method)
    {
        return true;
    }

    /**
     * Called instead of the original method
     *
     * @param mixed $proxy the proxy object
     * @param ReflectionMethod $method original method
     * @param array $args original methods arguments
     */
    public function invoke($proxy, ReflectionMethod $method, array $args)
    {
        return new InvocationBag($proxy,$method,$args);
    }
}