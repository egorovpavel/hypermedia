<?php

namespace Salesengineonline\Hypermedia\src;


use guymers\proxy\ProxyFactory;
use Illuminate\Routing\UrlGenerator;
use League\Flysystem\Exception;
use Salesengineonline\Hypermedia\src\Support\DummyInterceptor;
use Salesengineonline\Hypermedia\src\Support\InvocationBag;

if (!function_exists('hypermedia')) {

    function hypermedia()
    {
        return null;
    }
}

if (!function_exists('lnk')) {

    function rel($result)
    {
        if (!$result instanceof InvocationBag) {
            throw new Exception('InvocationBag expected by rel()');
        }
        $methodParams = $result->getMethod()->getParameters();
        $methodArgs = $result->getArgs();
        $res = collect($methodParams)
            ->map(function ($item) {
                return $item->getName();
            })
            ->zip($methodArgs)
            ->reduce(function ($acc, $item) {
                $acc[$item->first()] = $item->last();
                return $acc;
            }, []);
        $a = action(
            "{$result->getMethod()->getDeclaringClass()->getShortName()}@{$result->getMethod()->getName()}",
            $res
        );
        dd($a);
        return null;
    }
}

if (!function_exists('to')) {

    function to($class)
    {
        $klass = new \ReflectionClass($class);
        $methodOverrides = [
            new DummyInterceptor()
        ];
        $inst = ProxyFactory::create($klass, $methodOverrides);
        $r = $inst instanceof $class;
        return $inst;
    }
}