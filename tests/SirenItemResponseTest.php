<?php

namespace Tests;


use Salesengineonline\Hypermedia\SirenItemResponse;


class SirenItemResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testSimpleModelResponse()
    {
        $model = new SimpleModelClass();
        $item = new SirenItemResponse($model);

        $response = $item->getResponse();
    }
}
