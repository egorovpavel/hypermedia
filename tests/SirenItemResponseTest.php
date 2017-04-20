<?php

namespace salesengineonline\hypermedia\tests;


use salesengineonline\hypermedia\src\SirenItemResponse;
use salesengineonline\hypermedia\tests\fixtures\SimpleModelClass;

class SirenItemResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testSimpleModelResponse()
    {
        $model = new SimpleModelClass();
        $item = new SirenItemResponse($model);

        $response = $item->getResponse();
    }
}
