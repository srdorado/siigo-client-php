<?php

namespace Srdorado\SiigoClient\Model\Client;

use Srdorado\SiigoClient\Model\Validator\ProductValidator;

class ClientProduct extends AbstractClient
{
    //TODO: add communt

    public function __construct(string $baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
        $this->initGuzzleClient();
        $this->validator = new ProductValidator();
    }

    public function getHeaders(array $params = []): array
    {
        // TODO: Implement getHeaders() method.
        return [];
    }
}
