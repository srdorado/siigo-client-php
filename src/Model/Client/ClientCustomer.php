<?php

namespace Srdorado\SiigoClient\Model\Client;

use http\Exception;
use Srdorado\SiigoClient\Exception\Rule\UrlRuleRequestException;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Model\Validator\CustomerValidator;

class ClientCustomer extends AbstractClient
{
    //TODO: add communt

    public function __construct(string $baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
        $this->client = new \GuzzleHttp\Client();
        $this->validator = new CustomerValidator();
    }

    public function getHeaders(array $params = []): array
    {
        $headers = \Srdorado\SiigoClient\Enum\EndPoint\Customer::HEADER_POST;
        $headers['Authorization'] = $params['access_token'];
        return $headers;
    }

    /**
     *
     * @param EntityInterface|null $entity
     * @return string //Id de client siggo or ''
     * @throws UrlRuleRequestException
     */
    public function create(EntityInterface $entity = null): string
    {
        //set token before send request
        $clientId = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Customer::CREATE, $entity);
        $body = $this->validator->getBody(\Srdorado\SiigoClient\Enum\EndPoint\Customer::CREATE, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $urlRequest = $this->getRequestUrl(\Srdorado\SiigoClient\Enum\EndPoint\Customer::CREATE);
        $result = $this->post($urlRequest, $headers, json_encode($body));
        if ($result['code'] === 201) {
            $body = json_decode($result['contents'], true);
            $clientId = $body['id'];
        } else {
            $message =  'reponse - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $clientId;
    }

    public const CREATE = 'v1/customers';
    public const GET_ALL = 'v1/customers';
    public const GET_BY_ID = 'v1/customers/%s';
    public const UPDATE = 'v1/customers/%s';
    public const DELETE = 'v1/customers/%s';
}
