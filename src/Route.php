<?php

namespace SharkEzz\QuickPath;

use SharkEzz\QuickPath\Exceptions\InvalidMethodException;
use SharkEzz\QuickPath\Exceptions\RouteException;
use SharkEzz\QuickPath\Interfaces\RouteInterface;

class Route implements RouteInterface
{
    private const ALLOWED_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    private $matchTypes = [
        'i'  => '([0-9]++)',
        's'  => '([0-9A-Za-z\-]+)',
    ];

    /**
     * The path is the route with all the parameters
     * @var string
     */
    private $path;

    /**
     * The url is the route called with parameters replaced with values
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $action;

    /**
     * @var integer
     */
    private $parametersCount;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var string
     */
    private $regex;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @inheritDoc
     * @throws InvalidMethodException
     * @throws RouteException
     */
    public function __construct(string $path, string $method, string $name, string $action)
    {
        $this->name = $name;
        $this->action = $action;
        $this->method = $this->validateMethod($method);
        $this->processPath($path);
        $this->basePath = $this->setBasePath();
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getAction()
    {
        return $this->action;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }

    public function getParametersCount(): int
    {
        return $this->parametersCount;
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    private function setBasePath(): string
    {
        $path = explode('/', $this->path)[1];
        return '/'.$path;
    }

    public function getParametersName(): array
    {
        return $this->parameters;
    }

    /**
     * @param string $method
     * @return string
     * @throws InvalidMethodException
     */
    private function validateMethod(string $method): string
    {
        if(in_array($method, self::ALLOWED_METHODS))
        {
            return $method;
        }
        else
        {
            throw new InvalidMethodException('Method '.$method.' is not supported');
        }
    }

    /**
     * @param string $path
     * @throws RouteException
     */
    private function processPath(string $path)
    {
        preg_match_all('`(.|)\[([^:\]]*+)(?::([^:\]]*+))?\]`', $path, $matches, PREG_SET_ORDER);
        foreach ($matches as $match)
        {
            $this->parameters[] = $match[2];
        }
        $this->path = $path;
        $this->parametersCount = count($matches);
        if($this->parametersCount !== 0)
        {
            $this->regex = $this->createRegex($path, $matches);
        }
        else
        {
            $this->regex = '';
        }
    }

    /**
     * @param string $path
     * @param array $matches
     * @return string
     * @throws RouteException
     */
    private function createRegex(string $path, array $matches): string
    {
        $regex = '`';
        foreach ($matches as $match)
        {
            $type = $this->getMatchType($match[3]);
            $regex .= $type.'\-';
        }
        $regex = substr($regex, 0, -2);
        $regex .= '`';
        return $regex;
    }

    /**
     * @param string $identifier
     * @return mixed
     * @throws RouteException
     */
    private function getMatchType(string $identifier)
    {
        if(array_key_exists($identifier, $this->matchTypes))
        {
            return $this->matchTypes[$identifier];
        }
        else
        {
            throw new RouteException('Match type identifier '.$identifier.' not found');
        }
    }
}
