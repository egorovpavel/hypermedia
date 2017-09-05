<?php

namespace Salesengineonline\Hypermedia\src\Support;


use Illuminate\Http\Request;

class PageableRequest extends Request
{
    private $pageable;

    public function withPageable(?Pageable $pageable)
    {
        $this->pageable = $pageable ?? new Pageable(\request());
        return $this;
    }

    public function getPageable()
    {
        return $this->pageable;
    }
}