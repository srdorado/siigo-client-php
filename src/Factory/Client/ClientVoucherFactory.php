<?php

namespace Srdorado\SiigoClient\Factory\Client;

use Srdorado\SiigoClient\Factory\AbstractFactory;

class ClientVoucherFactory extends AbstractFactory
{
    public function __construct()
    {
    }

    public function create(string $class = '', array $params = [])
    {
        return new \Srdorado\SiigoClient\Model\Client\ClientVoucher();
    }
}
