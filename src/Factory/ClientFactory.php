<?php

namespace Srdorado\SiigoClient\Factory;

class ClientFactory extends AbstractFactory
{
    public function __construct()
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function create(string $class = '', array $params = [])
    {
        return new \ReflectionClass($class);
    }
}
