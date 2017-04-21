<?php

namespace Salesengineonline\Hypermedia;




class SirenItemResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testSimpleModelResponse()
    {
        //$model = new SimpleModelClass();
        $model = null;
        $item = new SirenItemResponse($model);

        $response = $item->getResponse();
    }
}
