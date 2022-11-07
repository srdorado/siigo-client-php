<?php

namespace Srdorado\SiigoClient\Model\Client;

use Srdorado\SiigoClient\Model\Validator\AbstractValidator;

abstract class AbstractClient
{
    protected string $baseUrl;

    protected \GuzzleHttp\Client $client;

    protected AbstractValidator $validator;

    protected string $accessToken;

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

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
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * @param string $accessKey
     */
    public function setAccessKey(string $accessKey): void
    {
        $this->accessKey = $accessKey;
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
     * @return void
     */
    protected function post(string $urlRequest, array $headers, string  $body): array
    {
        $request = new \GuzzleHttp\Psr7\Request('POST', $urlRequest, $headers, $body);
        $result = $this->client->sendAsync($request)->wait();
        return [
            'code' => $result->getStatusCode(),
            'contents' => (string)$result->getBody()
        ];
    }

    protected function get(string $urlRequest, array $headers, string  $body = ''): array
    {
        $request = new \GuzzleHttp\Psr7\Request('GET', $urlRequest, $headers, $body);
        $result = $this->client->sendAsync($request)->wait();
        return [
            'code' => $result->getStatusCode(),
            'contents' => (string)$result->getBody()
        ];
    }


    /**
     * @param array $params
     * @return array
     */
    abstract public function getHeaders(array $params = []): array;
}
