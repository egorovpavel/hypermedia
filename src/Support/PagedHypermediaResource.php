<?php

namespace Salesengineonline\Hypermedia\src;


use App\Http\Api\LandingPage\LandingPageListRequest;
use App\Http\Controllers\Dashboard\LandingPagesController;
use Salesengineonline\Hypermedia\src\Support\HypermediaRel;
use Salesengineonline\Hypermedia\src\Support\Page;
use Salesengineonline\Hypermedia\src\Support\Pageable;


abstract class PagedHypermediaResource extends HypermediaResource
{
    private $page;

    function __construct(Page $items)
    {
        $this->page = $items;
        $this->setItems($this->self(null)->getName(), $items->map(function ($item) {
            return $this->resource($item);
        }));

        $this->addRel($this->self(null)->asSelf());
        $this->addForm(frm(to(LandingPagesController::class)->index((new LandingPageListRequest())->withPageable(null)->withFilterable())));

        if ($items->hasNext()) {
            $this->addRel($this->self($items->getNextPageable())->asNext());
        }
        if ($items->hasPrev()) {
            $this->addRel($this->self($items->getPrevPageable())->asPrev());
        }
    }

    public function page()
    {
        return $this->page;
    }

    public abstract function resource($obj);

    public abstract function self(?Pageable $pageable): HypermediaRel;
}