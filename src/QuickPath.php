<?php

namespace SharkEzz\QuickPath;

use Psr\Http\Message\RequestInterface;
use SharkEzz\QuickPath\Interfaces\QuickPathInterface;
use SharkEzz\QuickPath\Interfaces\RouteInterface;

class QuickPath implements QuickPathInterface
{
    /**
     * @var RouteInterface[]
     */
    private $routes;

    /**
     * @var string[]
     */
    private $namedRoutes;

    /**
     * @inheritDoc
     */
    public function map(string $path, string $method, string $name, $action): void
    {
        $this->routes[] = new Route($path, $method, $name, $action);
        $this->namedRoutes[] = $name;
    }

    /**
     * @inheritDoc
     */
    public function match(RequestInterface $request): ?RouteInterface
    {
        // TODO: Implement match() method.
    }
}