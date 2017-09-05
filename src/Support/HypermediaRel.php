<?php
/**
 * Created by PhpStorm.
 * User: pavel.egorov
 * Date: 07/08/2017
 * Time: 18:53
 */

namespace Salesengineonline\Hypermedia\src\Support;


use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Request;

class HypermediaRel implements \JsonSerializable
{
    public $title;
    public $href;
    private $name;

    function __construct(Route $route,$href,$title = null)
    {
        $this->href = ltrim($href,'/');
        $this->title = $title;

        $this->withName($route->getName());
    }

    public function withName($name){
        $this->name = Request::root() . '/rels/' .$name;
        return $this;
    }

    public function asSelf(){
        $this->name = 'self';
        return $this;
    }

    public function asNext(){
        $this->name = 'next';
        return $this;
    }

    public function asPrev(){
        $this->name = 'prev';
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
            "href" => $this->href,
            "title" => $this->title
        ]);
    }
}