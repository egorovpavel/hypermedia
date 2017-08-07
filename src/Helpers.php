<?php

namespace salesengineonline\hypermedia\src;


if (!function_exists('hypermedia')) {

    function hypermedia()
    {
        return new ResponseBuilder();
    }
}