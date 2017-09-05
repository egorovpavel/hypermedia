<?php

namespace Salesengineonline\Hypermedia\src;


use guymers\proxy\ProxyFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use League\Flysystem\Exception;
use Salesengineonline\Hypermedia\src\Support\DummyInterceptor;
use Salesengineonline\Hypermedia\src\Support\HypermediaFilterBuilder;
use Salesengineonline\Hypermedia\src\Support\HypermediaForm;
use Salesengineonline\Hypermedia\src\Support\HypermediaFormField;
use Salesengineonline\Hypermedia\src\Support\HypermediaFormSuggest;
use Salesengineonline\Hypermedia\src\Support\HypermediaRel;
use Salesengineonline\Hypermedia\src\Support\InvocationBag;
use Salesengineonline\Hypermedia\src\Support\PageableRequest;

if (!function_exists('hypermedia')) {

    function hypermedia()
    {
        return null;
    }
}

if (!function_exists('rel')) {

    function rel($result, $cuies = true): HypermediaRel
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
            ->reduce(function ($acc, Collection $item) {
                if ($item->last() instanceof PageableRequest) {
                    return array_merge($acc, $item->last()->getPageable()->getNotDefault());
                }
                if(is_scalar($item->last())){
                    $acc[$item->first()] = $item->last();
                }
                return $acc;
            }, []);

        $klassName = str_replace('App\\Http\\Controllers\\', '', $result->getMethod()->getDeclaringClass()->getName());
        $action = "{$klassName}@{$result->getMethod()->getName()}";
        $href = count($res) > 0
            ? action($action, $res, true)
            : action($action, null, true);

        $route = Route::getRoutes()->getByAction('App\\Http\\Controllers\\' . $action);
        return new HypermediaRel($route, rtrim($href, "?"));
    }
}

if (!function_exists('frm')) {

    function frm($result): HypermediaForm
    {
        if (!$result instanceof InvocationBag) {
            throw new Exception('InvocationBag expected by frm()');
        }
        $klassName = $result->getMethod()->getDeclaringClass()->getName();
        $action = "{$klassName}@{$result->getMethod()->getName()}";
        $route = Route::getRoutes()->getByAction($action);
        return new HypermediaForm($route, $result->getMethod(), $result->getArgs(), rel($result));
    }
}


if (!function_exists('suggest')) {

    function suggest($result) : HypermediaFormSuggest
    {
        return new HypermediaFormSuggest($result);
    }
}

if (!function_exists('field')) {

    function field($name) : HypermediaFormField
    {
        return new HypermediaFormField($name);
    }
}

if (!function_exists('filter')) {

    function filter($name) : HypermediaFilterBuilder
    {
        return new HypermediaFilterBuilder($name);
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