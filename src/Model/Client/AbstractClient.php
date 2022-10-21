<?php

namespace Srdorado\SiigoClient\Model\Client;

use Srdorado\SiigoClient\Model\Validator\AbstractValidator;

abstract class AbstractClient
{
    protected string $baseUrl;

    protected \GuzzleHttp\Client $client;

    protected AbstractValidator $validator;

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setClient(\GuzzleHttp\Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @param string $endPoint
     * @return string
     */
    public function getRequestUrl(string $endPoint): string
    {
        return $this->baseUrl . $endPoint;
    }

    /**
     * @param array $params
     * @return array
     */
    abstract public function getHeaders(array $params = []): array;
}
