<?php

namespace SharkEzz\QuickPath\Interfaces;

interface RouteInterface
{
    /**
     * RouteInterface constructor.
     * @param string $path
     * @param string $method
     * @param string $name
     * @param string $action
     */
    public function __construct(string $path, string $method, string $name, string $action);

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
     * @return string
     */
    public function getBasePath(): string;

    /**
     * @return int
     */
    public function getParametersCount(): int;

    /**
     * @return string
     */
    public function getRegex(): string;

    /**
     * @return array
     */
    public function getParametersName(): array;
}
