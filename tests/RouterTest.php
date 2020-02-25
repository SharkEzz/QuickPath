<?php

namespace SharkEzz\QuickPath\Tests;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use SharkEzz\QuickPath\QuickPath;

class RouterTest extends TestCase
{
    /**
     * @var QuickPath
     */
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
        $this->assertEquals('test', $route['name']);
        $this->assertEquals('/test', $route['route']->getPath());
        $this->assertEquals('TestController#test', $route['action']);
        $this->assertEquals('GET', $route['route']->getMethod());
    }

    public function testMatchGETWithParameters()
    {
        $request = new Request('GET', '/test/test-5');

        $this->router->map('/test/[name:s]-[id:i]', 'GET', 'test', 'TestController#test');
        $route = $this->router->match($request);
        $this->assertEquals('test', $route['name']);
        $this->assertEquals('/test/[name:s]-[id:i]', $route['route']->getPath());
        $this->assertEquals('TestController#test', $route['action']);
        $this->assertEquals('GET', $route['route']->getMethod());
        $this->assertEquals(['name' => 'test', 'id' => '5'], $route['params']);
    }
}
