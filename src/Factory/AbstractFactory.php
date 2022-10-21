<?php

namespace Srdorado\SiigoClient\Factory;

abstract class AbstractFactory
{
    abstract public function create(string $class = '', array $params = []);
}
