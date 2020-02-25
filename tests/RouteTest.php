<?php

namespace SharkEzz\QuickPath\Tests;

use PHPUnit\Framework\TestCase;
use SharkEzz\QuickPath\Exceptions\InvalidMethodException;
use SharkEzz\QuickPath\Route;

class RouteTest extends TestCase
{
    /**
     * @var Route
     */
    private $route1;

    /**
     * @var Route
     */
    private $route2;

    protected function setUp(): void
    {
        $this->route1 = new Route('/test', 'GET', 'testGET', 'test');
        $this->route2 = new Route('/test/[name:s]-[id:i]-[test:s]', 'GET', 'testGETParams', 'test2');
    }

    public function testGETRouteWithoutParameters()
    {
        $this->assertEquals('testGET', $this->route1->getName());
        $this->assertEquals(0, $this->route1->getParametersCount());
        $this->assertEquals('/test', $this->route1->getPath());
        $this->assertEquals('test', $this->route1->getAction());
    }

    public function testGETRouteWithParameters()
    {
        $this->assertEquals(3, $this->route2->getParametersCount());
        $this->assertEquals('/test/[name:s]-[id:i]-[test:s]', $this->route2->getPath());
        $this->assertEquals('`([0-9A-Za-z\-]+)\-([0-9]++)\-([0-9A-Za-z\-]+)`', $this->route2->getRegex());
    }

}