<?php

namespace SharkEzz\QuickPath;

use Psr\Http\Message\RequestInterface;
use SharkEzz\QuickPath\Exceptions\RouteAlreadyExistException;
use SharkEzz\QuickPath\Exceptions\RouteNotFoundException;
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
    private $namedRoutes = [];

    /**
     * @var string
     */
    private $currentUrl;

    /**
     * @inheritDoc
     */
    public function map(string $path, string $method, string $name, $action): void
    {
        if(!in_array($name, $this->namedRoutes))
        {
            $this->routes[] = new Route($path, $method, $name, $action);
            $this->namedRoutes[] = $name;
        }
        else
        {
            throw new RouteAlreadyExistException('Route '.$name. ' already exist');
        }
    }

    /**
     * @inheritDoc
     */
    public function match(RequestInterface $request): array
    {
        $request_url = $request->getUri();
        $this->currentUrl = $request_url;
        $request_method = $request->getMethod();

        $matchedRoute = null;
        $params = null;
        $name   = null;
        $action = null;

        foreach ($this->routes as $route)
        {
            if ($route->getBasePath() === $this->getBasePath($request_url) && $route->getMethod() === $request_method)
            {
                $routeRegex = $route->getRegex();
                if(!empty($routeRegex))
                {
                    $routeParams = $route->getParametersName();
                    $matchedRoute = $route;
                    $name = $route->getName();
                    $action = $route->getAction();
                    preg_match($routeRegex, $request_url, $matches);
                    unset($matches[0]);
                    $matches = array_values($matches);
                    foreach ($routeParams as $index => $value)
                    {
                        $params[$value] = $matches[$index];
                    }
                }
                else
                {
                    $matchedRoute = $route;
                    $name = $route->getName();
                    $action = $route->getAction();
                    $params = [];
                }
            }
            else
            {
                throw new RouteNotFoundException('Route ' . $request_url . ' not found');
            }
        }

        return [
            'route' => $matchedRoute,
            'params' => $params,
            'name'   => $name,
            'action' => $action
        ];
    }

    private function getBasePath(string $url)
    {
        $path = explode('/', $url)[1];
        return '/'.$path;
    }
}
