<?php

namespace SharkEzz\QuickPath\Interfaces;

use Psr\Http\Message\RequestInterface;

interface QuickPathInterface
{
    /**
     * @param string $path
     * @param string $method
     * @param string $name
     * @param $action
     */
    public function map(string $path, string $method, string $name, $action): void;

    /**
     * @param RequestInterface $request
     * @return RouteInterface|null
     */
    public function match(RequestInterface $request): ?RouteInterface;
}