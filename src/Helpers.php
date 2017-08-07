<?php

namespace Salesengineonline\Hypermedia\src;


if (!function_exists('hypermedia')) {

    function hypermedia()
    {
        return new ResponseBuilder();
    }
}

if (!function_exists('lnk')) {

    function lnk($result)
    {
        return $result;
    }
}

if (!function_exists('to')) {

    function to($class)
    {
        dd($class);
        return null;
    }
}