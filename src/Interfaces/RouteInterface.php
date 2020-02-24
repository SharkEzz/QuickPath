<?php

namespace SharkEzz\QuickPath\Interfaces;

interface RouteInterface
{
    /**
     * RouteInterface constructor.
     * @param string $path
     * @param string $method
     * @param string $name
     * @param $action
     */
    public function __construct(string $path, string $method, string $name, $action);

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return mixed
     */
    public function getAction();

    /**
     * @return array|null
     */
    public function getParameters(): ?array;
}