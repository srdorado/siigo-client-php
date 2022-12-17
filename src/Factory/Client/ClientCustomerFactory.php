<?php

namespace Srdorado\SiigoClient\Factory\Client;

use Srdorado\SiigoClient\Factory\AbstractFactory;

class ClientCustomerFactory extends AbstractFactory
{
    public function __construct()
    {
    }

    public function create($class = '', $params = [])
    {
        return new \Srdorado\SiigoClient\Model\Client\ClientCustomer();
    }
}
