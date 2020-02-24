<?php

namespace SharkEzz\QuickPath\Tests;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use SharkEzz\QuickPath\QuickPath;

class RouterTest extends TestCase
{
    private $router;

    protected function setUp(): void
    {
        $this->router = new QuickPath();
    }

    public function testMatchGET()
    {
        $request = new Request('GET', '/test');

        $this->router->map('/test', 'GET', 'test', 'TestController#test');
        $route = $this->router->match($request);
        $this->assertEquals('test', $route->getName());
        $this->assertEquals('/test', $route->getPath());
        $this->assertEquals('TestController#test', $route->getAction());
        $this->assertEquals('GET', $route->getMethod());
    }

    public function testMatchGETWithParameters()
    {
        $request = new Request('GET', '/test/test-5');

        $this->router->map('/test/[name:s]-[id:i]', 'GET', 'test', 'TestController#test');
        $route = $this->router->match($request);
        $this->assertEquals('test', $route->getName());
        $this->assertEquals('/test/[name:s]-[id:i]', $route->getPath());
        $this->assertEquals('TestController#test', $route->getAction());
        $this->assertEquals('GET', $route->getMethod());
        $this->assertEquals(['name' => 'test', 'id' => '5'], $route->getParameters());
    }

    public function testMatchGETWithParametersAndCallback()
    {
        $request = new Request('GET', '/test/test-5');

        $this->router->map('/test/[name:s]-[id:i]', 'GET', 'test', function (string $name, string $id) {return $name.'-'.$id;});
        $route = $this->router->match($request);
        $this->assertEquals('test', $route->getName());
        $this->assertEquals('/test/[name:s]-[id:i]', $route->getPath());
        $this->assertEquals('GET', $route->getMethod());
        $this->assertEquals(['name' => 'test', 'id' => '5'], $route->getParameters());
        $this->assertEquals('test-5', $route->getAction());
    }


}