<?php

namespace Srdorado\SiigoClient\Model\Client;

use GuzzleHttp\Exception\GuzzleException;
use Srdorado\SiigoClient\Enum\ClientType;
use Srdorado\SiigoClient\Model\Entity;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Model\Validator\TokenValidator;

class ClientToken extends AbstractClient
{
    private string $username;

    private string $accessKey;

    //Valores retornados por la respuesta
    private string $accessToken;

    private string $startDate;

    private string $endDate;

    private int $expirationTime;

    private string $tokenType;

    private string $scope;

    public function __construct(string $baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
        $this->client = new \GuzzleHttp\Client();
        $this->validator = new TokenValidator();
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
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
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return int
     */
    public function getExpirationTime(): int
    {
        return $this->expirationTime;
    }

    /**
     * @param int $expirationTime
     */
    public function setExpirationTime(int $expirationTime): void
    {
        $this->expirationTime = $expirationTime;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType(string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }

    /**
     * @throws GuzzleException
     */
    public function getToken(EntityInterface $entity = null): string
    {
        if (!$entity) {
            $data = [
                'username' => $this->username,
                'access_key' => $this->accessKey
            ];
            $entity = new Entity(ClientType::TOKEN);
            $entity->setData($data);
        }

        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Token::AUTH, $entity);

        $body = $this->validator->getBody(\Srdorado\SiigoClient\Enum\EndPoint\Token::AUTH, $entity);

        $headers = $this->getHeaders();

        $urlRequest = $this->getRequestUrl(\Srdorado\SiigoClient\Enum\EndPoint\Token::AUTH);

        $result = $this->post($urlRequest, $headers, json_encode($body));

        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $this->accessToken = $body['access_token'];
            $this->expirationTime = $body['expires_in'];
            $this->tokenType = $body['token_type'];
            $this->scope = $body['scope'];
        }

        return $this->accessToken ?? '';
    }

    public function getHeaders(array $params = []): array
    {
        return \Srdorado\SiigoClient\Enum\EndPoint\Token::HEADER_POST;
    }
}
