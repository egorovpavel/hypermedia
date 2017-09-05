<?php

namespace Salesengineonline\Hypermedia\src\Support;


trait FilterableRequestTrait
{
    public function withFilterable(){
        return $this;
    }

    public abstract function getFilters();
}