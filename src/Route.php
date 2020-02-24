<?php

namespace SharkEzz\QuickPath;

use SharkEzz\QuickPath\Exceptions\InvalidMethodException;
use SharkEzz\QuickPath\Interfaces\RouteInterface;

class Route implements RouteInterface
{
    private const ALLOWED_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    private const TYPES = [
        'int' => 'i',
        'string' => 's',
        'controller' => 'c',
        'action' => 'a'
    ];

    /**
     * @var string
     */
    private $path;

    /**
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
     * @var mixed
     */
    private $action;

    /**
     * @var integer
     */
    private $parametersCount;

    /**
     * @var array|null
     */
    private $parameters;

    /**
     * @inheritDoc
     * @throws InvalidMethodException
     */
    public function __construct(string $path, string $method, string $name, $action)
    {
        $this->name = $name;
        $this->action = $action;
        $this->method = $this->validateMethod($method);
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

    /**
     * @inheritDoc
     */
    public function getParameters(): ?array
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
}