<?php

namespace Srdorado\SiigoClient\Model\Client;

use Srdorado\SiigoClient\Exception\Rule\BadRequest;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Model\Validator\AbstractValidator;
use Srdorado\SiigoClient\Model\Validator\ProductValidator;

class ClientProduct extends AbstractClient
{
    /**
     * Construct
     *
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
        $this->initGuzzleClient();
        $this->validator = new ProductValidator();
    }

    /**
     * @param array $params
     * @return array
     */
    public function getHeaders(array $params = []): array
    {
        $headers = \Srdorado\SiigoClient\Enum\EndPoint\Customer::HEADER_POST;
        $headers['Authorization'] = $params['access_token'];
        return $headers;
    }


    /**
     * Create product in siigo
     *
     * @param EntityInterface|null $entity
     * @return string
     * @throws BadRequest
     */
    public function create(EntityInterface $entity = null): string
    {
        $productId = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Product::CREATE, $entity);
        $body = $this->validator->getBody(\Srdorado\SiigoClient\Enum\EndPoint\Product::CREATE, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $urlRequest = $this->getRequestUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::CREATE);
        $result = $this->post($urlRequest, $headers, json_encode($body));
        if ($result['code'] === 201) {
            $body = json_decode($result['contents'], true);
            $productId = $body['id'];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $productId;
    }


    /**
     * Get all products
     *
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getAll(EntityInterface $entity = null): array
    {
        $products = [];
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Product::GET_ALL, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::GET_ALL, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->get($urlRequest, $headers);
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $products = $body['results'];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $products;
    }

    /**
     * Get product by id
     *
     * @param EntityInterface|null $entity
     * @return string
     * @throws BadRequest
     */
    public function getById(EntityInterface $entity = null): string
    {
        $productId = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Product::GET_BY_ID, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::GET_BY_ID, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->get($urlRequest, $headers);
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $productId = $body['id'];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $productId;
    }

    /**
     * Get product by code
     *
     * @param EntityInterface|null $entity
     * @return string
     * @throws BadRequest
     */
    public function getByCode(EntityInterface $entity = null): string
    {
        $productId = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Product::GET_BY_CODE, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::GET_BY_CODE, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->get($urlRequest, $headers);
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $products = $body['results'];
            $productId = $products[0]['id'];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $productId;
    }

    /**
     * Update product
     *
     * @param EntityInterface|null $entity
     * @return string
     * @throws BadRequest
     */
    public function update(EntityInterface $entity = null): string
    {
        //set token before send request
        $productId = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Product::UPDATE . 'U', $entity);
        $id = $entity->getAndRemove(AbstractValidator::URL_REQUEST);
        $body = $this->validator->getBody(\Srdorado\SiigoClient\Enum\EndPoint\Product::UPDATE, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $entity->setData($id[AbstractValidator::URL_REQUEST]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::UPDATE, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->put($urlRequest, $headers, json_encode($body));
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $productId = $body['id'];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $productId;
    }

    /**
     * Delete product
     *
     * @param EntityInterface|null $entity
     * @return bool
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function delete(EntityInterface $entity = null): bool
    {
        $result = false;
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Product::DELETE . 'D', $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::DELETE, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->del($urlRequest, $headers);
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $result = $body['deleted'];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $result;
    }

    /**
     * Get account groups
     *
     * @return array
     * @throws BadRequest
     */
    public function getAccountGroups(): array
    {
        $result = false;
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::ACCOUNT_GROUPS);
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
     * Get WareHouses
     *
     * @return array
     * @throws BadRequest
     */
    public function getWareHouses(): array
    {
        $result = false;
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Product::WAREHOUSES);
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
}
