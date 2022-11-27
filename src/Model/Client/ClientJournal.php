<?php

namespace Srdorado\SiigoClient\Model\Client;

use Srdorado\SiigoClient\Exception\Rule\BadRequest;
use Srdorado\SiigoClient\Exception\Rule\UrlRuleRequestException;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Model\Validator\JournalValidator;

class ClientJournal extends AbstractClient
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
        $this->validator = new JournalValidator();
    }

    public function getHeaders(array $params = []): array
    {
        $headers = \Srdorado\SiigoClient\Enum\EndPoint\Customer::HEADER_POST;
        $headers['Authorization'] = $params['access_token'];
        return $headers;
    }

    /**
     * Create Journal in siigo
     *
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function create(EntityInterface $entity = null): array
    {
        $endpoint = \Srdorado\SiigoClient\Enum\EndPoint\Journal::CREATE;
        return $this->getBodyGeneric(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::CREATE,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getAll(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_ALL,
            $entity,
            $allResponse
        );
    }

    /**
     * Get credit note by id
     *
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getById(EntityInterface $entity = null): array
    {
        $response = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_ID, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_ID, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->get($urlRequest, $headers);
        if ($result['code'] === 200) {
            $result = json_decode($result['contents'], true);
            $response = $result;
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $response;
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getByCreatedStart(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_CREATED_START,
            $entity,
            $allResponse
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getByUpdatedStart(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_UPDATED_START,
            $entity,
            $allResponse
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getByDateStart(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_DATE_START,
            $entity,
            $allResponse
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getByDateEnd(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_DATE_END,
            $entity,
            $allResponse
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getByCreatedEnd(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_CREATED_END,
            $entity,
            $allResponse
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getByUpdatedEnd(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_UPDATED_END,
            $entity,
            $allResponse
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @param bool $allResponse
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getByDocumentId(EntityInterface $entity = null, bool $allResponse = false): array
    {
        return $this->getListRequest(
            \Srdorado\SiigoClient\Enum\EndPoint\Journal::GET_BY_DOCUMENT_ID,
            $entity,
            $allResponse
        );
    }
}
