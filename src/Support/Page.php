<?php

namespace Salesengineonline\Hypermedia\src\Support;


use App\Libs\Repo\EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class Page extends Collection
{
    private $query;
    private $original;
    private $pageable;
    private $hasNext;
    private $hasPrev;

    function __construct($query)
    {
        if ($query instanceof EloquentBuilder) {
            $this->pageable = new Pageable(request());
            $this->original = $query;
            $this->query = $query instanceof EloquentBuilder ? $query->getQuery() : $query;
            $total = $this->query->getCountForPagination();
            $this->original
                ->skip(($this->pageable->getPage() - 1) * $this->pageable->getSize())
                ->take($this->pageable->getSize())
                ->orderBy($this->pageable->getSort(), $this->pageable->getDir());
            $this->hasNext = $total > ($this->pageable->getPage() - 1) * $this->pageable->getSize() + $this->pageable->getSize();
            $this->hasPrev = ($this->pageable->getPage() - 1) * $this->pageable->getSize() - $this->pageable->getSize() >= 0;
            parent::__construct($this->original->get()->items);
        } else {
            parent::__construct($query);
        }

    }

    public function hasNext()
    {
        return $this->hasNext;
    }

    public function hasPrev()
    {
        return $this->hasPrev;
    }

    public function getNextPageable(): Pageable
    {
        $pageable = $this->pageable;
        $pageable->setPage($pageable->getPage() + 1);
        return $pageable;
    }

    public function getPrevPageable(): Pageable
    {
        $pageable = $this->pageable;
        $pageable->setPage($pageable->getPage() - 1);
        return $pageable;
    }
}