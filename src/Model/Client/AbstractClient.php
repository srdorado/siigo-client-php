<?php

namespace Srdorado\SiigoClient\Model\Client;

use Srdorado\SiigoClient\Exception\Rule\BadRequest;
use Srdorado\SiigoClient\Exception\Rule\UrlRuleRequestException;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Model\Validator\AbstractValidator;
use GuzzleHttp\HandlerStack;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

abstract class AbstractClient
{
    protected string $baseUrl;

    protected \GuzzleHttp\Client $client;

    protected AbstractValidator $validator;

    protected string $accessToken;


    /**
     * Init GuzzleClient and set limit request per minute
     *
     * @return void
     */
    protected function initGuzzleClient(): void
    {
        $stack = HandlerStack::create();
        $stack->push(RateLimiterMiddleware::perMinute(100));

        $this->client = new \GuzzleHttp\Client(
            [
                'handler' => $stack,
            ]
        );
    }

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
        return $this->accessToken;
    }

    /**
     * @param string $accessKey
     */
    public function setAccessKey(string $accessKey): void
    {
        $this->accessToken = $accessKey;
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
     * @param string $urlRequest
     * @param array $headers
     * @param string $body
     * @return array
     */
    protected function put(string $urlRequest, array $headers, string $body = ''): array
    {
        $request = new \GuzzleHttp\Psr7\Request('PUT', $urlRequest, $headers, $body);
        $result = $this->client->sendAsync($request)->wait();
        return [
            'code' => $result->getStatusCode(),
            'contents' => (string)$result->getBody()
        ];
    }

    /**
     * @param string $urlRequest
     * @param array $headers
     * @param string $body
     * @return array
     */
    protected function del(string $urlRequest, array $headers, string $body = ''): array
    {
        $request = new \GuzzleHttp\Psr7\Request('DELETE', $urlRequest, $headers, $body);
        $result = $this->client->sendAsync($request)->wait();
        return [
            'code' => $result->getStatusCode(),
            'contents' => (string)$result->getBody()
        ];
    }

    /**
     * @param string $endPoint
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getListRequest(string $endPoint, EntityInterface $entity = null, bool $allResponse = false): array
    {
        $result = [];
        if ($allResponse) {
            $result = $this->getUrlGenericList($endPoint, $entity);
        } else {
            $result = $this->getUrlGenericListWithKey('results', $endPoint, $entity);
        }
        return $result;
    }

    /**
     * @param string $endPoint
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException|\Srdorado\SiigoClient\Exception\Rule\BadRequest
     */
    protected function getUrlGenericList(string $endPoint, EntityInterface $entity = null): array
    {
        $result = [];
        $this->validator->validate($endPoint, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl($endPoint, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->get($urlRequest, $headers);
        if ($result['code'] === 200) {
            $result = json_decode($result['contents'], true);
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $result;
    }

    /**
     * @param string $key
     * @param string $endPoint
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    protected function getUrlGenericListWithKey(string $key, string $endPoint, EntityInterface $entity = null): array
    {
        $response = [];
        $this->validator->validate($endPoint, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl($endPoint, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->get($urlRequest, $headers);
        if ($result['code'] === 200) {
            $result = json_decode($result['contents'], true);
            $response = $result[$key];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $response;
    }

    /**
     * @param string $key
     * @param string $endPoint
     * @param EntityInterface|null $entity
     * @return string
     * @throws BadRequest
     */
    protected function getUrlGenericWithKey(string $key, string $endPoint, EntityInterface $entity = null): string
    {
        $response = '';
        $this->validator->validate($endPoint, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl($endPoint, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->get($urlRequest, $headers);
        if ($result['code'] === 200) {
            $result = json_decode($result['contents'], true);
            $response = $result[$key];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $response;
    }

    /**
     * @param string $key
     * @param string $endPoint
     * @param EntityInterface|null $entity
     * @return string
     * @throws BadRequest
     */
    protected function getBodyGenericWithKey(string $key, string $endPoint, EntityInterface $entity = null): string
    {
        $response = [];
        $this->validator->validate($endPoint, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $body = $this->validator->getBody($endPoint, $entity);
        $urlRequest = $this->getRequestUrl($endPoint);
        $result = $this->post($urlRequest, $headers, json_encode($body));
        if ($result['code'] === 201) {
            $result = json_decode($result['contents'], true);
            $response = $result[$key];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $response;
    }

    /**
     * @param string $endPoint
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    protected function getBodyGeneric(string $endPoint, EntityInterface $entity = null): array
    {
        $response = [];
        $this->validator->validate($endPoint, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $body = $this->validator->getBody($endPoint, $entity);
        $urlRequest = $this->getRequestUrl($endPoint);
        $result = $this->post($urlRequest, $headers, json_encode($body));
        if ($result['code'] === 201) {
            $result = json_decode($result['contents'], true);
            $response = $result;
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $response;
    }

    /**
     * @param array $params
     * @return array
     */
    abstract public function getHeaders(array $params = []): array;
}
