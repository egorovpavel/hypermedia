<?php
/**
 * Created by PhpStorm.
 * User: pavel.egorov
 * Date: 07/08/2017
 * Time: 15:32
 */

namespace Salesengineonline\Hypermedia\src\Support;


use App\Libs\Http\Pagination;

trait ListResourceRequestTrait
{
    public function getFilters()
    {
        return [];
    }

    public function getPagination() : Pagination
    {
        return new Pagination();
    }
}