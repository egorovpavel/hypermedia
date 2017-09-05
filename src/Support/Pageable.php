<?php

namespace Salesengineonline\Hypermedia\src\Support;


use Illuminate\Http\Request;

class Pageable
{
    /**
     * @var int
     */
    public $page = 1;
    /**
     * @var int
     */
    public $size = 30;
    /**
     * @var string
     */
    public $sort = 'id';
    /**
     * @var string
     */
    public $dir = 'desc';

    /**
     * @param int $page
     * @param int $perPage
     * @param string $order
     * @param string $direction
     */
    public function __construct(Request $req)
    {

        $this->page = intval($req->get('page',1));
        $this->size = intval($req->get('size',30));
        $this->sort = str_replace('-', '', $req->get('sort', '-id'));
        $this->dir = $req->get('sort', '-id')[0] == '-'
            ? 'desc'
            : 'asc';
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getSort(): string
    {
        return $this->sort;
    }

    /**
     * @param string $sort
     */
    public function setSort(string $sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     */
    public function setDir(string $dir)
    {
        $this->dir = $dir;
    }

    public function getNotDefault(){
        return array_filter([
            'page' => $this->getPage() != 1 ? $this->getPage() : null,
            'sort' => $this->getSort() != 'id' ? $this->getSort() : null,
            'size' => $this->getSize() != 30 ? $this->getSize() : null,
            'dir' => $this->getDir() != 'desc' ? $this->getDir() : null,
        ]);
    }
}