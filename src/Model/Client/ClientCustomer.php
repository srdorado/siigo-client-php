<?php

namespace Srdorado\SiigoClient\Model\Client;

class ClientCustomer extends AbstractClient
{
    //TODO: add communt

    public function __construct()
    {
    }

    public function getHeaders(array $params = []): array
    {
        $headers = \Srdorado\SiigoClient\Enum\EndPoint\Customer::HEADER_POST;
        $headers['Authorization'] = $params['access_token'];
        return $headers;
    }
}
