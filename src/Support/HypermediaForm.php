<?php

namespace Salesengineonline\Hypermedia\src\Support;


use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class HypermediaForm implements \JsonSerializable
{
    public $_links = [];
    public $method;
    public $contentType = "application/json";
    public $fields = [];

    private $name;
    private $pseudoName;

    function __construct(Route $route, \ReflectionMethod $method, $args, HypermediaRel $rel)
    {
        $this->method = $route->methods()[0];
        $this->_links['self'] = [
            'href' => $rel->asSelf()->href
        ];
        $this->withName($route->getName());
        $req = $this->getFirstRequestParameter($method);
        if($req){
            $props = $this->getOwnProperties($req->getClass());
            $this->fields = $this->getFormFields($props,$args);
        }
    }

    private function getFormFields($props, $args){
        return collect($props)->map(function($field){
            return $field;
        });
    }

    private function getOwnProperties(\ReflectionClass $class): ?array {
        return $class->hasMethod('form')
            ? $class->newInstanceWithoutConstructor()->form()
            : null;
    }

    private function getFirstRequestParameter(\ReflectionMethod $method): ?\ReflectionParameter
    {
        foreach ($method->getParameters() as $parameter){
            if($parameter->hasType() && $parameter->getClass()->isSubclassOf(Request::class)){
                return $parameter;
            }
        }
        return null;
    }

    public function withName($name)
    {
        $pseudoName = $this->pseudoName ? ".$this->pseudoName":"";
        $this->name = \Illuminate\Support\Facades\Request::root() . '/rels/' . $name . $pseudoName ;
        return $this;
    }

    public function withPseudoName($name)
    {
        $this->pseudoName = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array_filter([
            "_links" => $this->_links,
            "method" => $this->method,
            "contentType" => $this->contentType,
            "fields" => $this->fields
        ]);
    }
}