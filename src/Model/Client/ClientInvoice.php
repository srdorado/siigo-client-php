<?php

namespace Srdorado\SiigoClient\Model\Client;

use Srdorado\SiigoClient\Exception\Rule\BadRequest;
use Srdorado\SiigoClient\Exception\Rule\UrlRuleRequestException;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Model\Validator\AbstractValidator;
use Srdorado\SiigoClient\Model\Validator\InvoiceValidator;

class ClientInvoice extends AbstractClient
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
        $this->validator = new InvoiceValidator();
    }

    public function getHeaders(array $params = []): array
    {
        $headers = \Srdorado\SiigoClient\Enum\EndPoint\Customer::HEADER_POST;
        $headers['Authorization'] = $params['access_token'];
        return $headers;
    }

    /**
     * Create invoice in siigo
     *
     * @param EntityInterface|null $entity
     * @return string //Id de client siggo or ''
     * @throws BadRequest
     */
    public function create(EntityInterface $entity = null): string
    {
        return $this->getBodyGenericWithKey(
            'id',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::CREATE,
            $entity
        );
    }

    /**
     * Update invoice
     *
     * @param EntityInterface|null $entity
     * @return string
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function update(EntityInterface $entity = null): string
    {
        //set token before send request
        $invoiceId = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::UPDATE . 'U', $entity);
        $id = $entity->getAndRemove(AbstractValidator::URL_REQUEST);
        $body = $this->validator->getBody(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::UPDATE, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $entity->setData($id[AbstractValidator::URL_REQUEST]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::UPDATE, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->put($urlRequest, $headers, json_encode($body));
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $invoiceId = $body['id'];
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $invoiceId;
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getAll(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_ALL,
            $entity
        );
    }

    /**
     * Get invoice by id
     *
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getById(EntityInterface $entity = null): array
    {
        $response = '';
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET . 'G', $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET, $entity);
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
     * Delete invoice
     *
     * @param EntityInterface|null $entity
     * @return bool
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function delete(EntityInterface $entity = null): bool
    {
        $result = false;
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::DELETE . 'D', $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::DELETE, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->del($urlRequest, $headers);
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $result = $body['deleted'];
        } else {
            $message =  'reponse - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $result;
    }

    /**
     * Annul invoice
     *
     * @param EntityInterface|null $entity
     * @return bool
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function annul(EntityInterface $entity = null): bool
    {
        $result = false;
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::ANNUL, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::ANNUL, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->post($urlRequest, $headers, '');
        if ($result['code'] === 200) {
            $body = json_decode($result['contents'], true);
            $result = $body['Annul'];
        } else {
            $message =  'reponse - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $result;
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByCreatedStart(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_CREATED_START,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByUpdatedStart(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_UPDATED_START,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByDateStart(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_DATE_START,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByDateEnd(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_DATE_END,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByCreatedEnd(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_CREATED_END,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByUpdatedEnd(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_UPDATED_END,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByCustomerBranchOffice(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_CUSTOMER_BRANCH_OFFICE,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByName(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_NAME,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByCustomerIdentification(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_CUSTOMER_IDENTIFICATION,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     */
    public function getByDocumentId(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericListWithKey(
            'results',
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::GET_BY_DOCUMENT_ID,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getPDF(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericList(
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::PDF,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     * @throws BadRequest
     * @throws UrlRuleRequestException
     */
    public function getStampErrors(EntityInterface $entity = null): array
    {
        return $this->getUrlGenericList(
            \Srdorado\SiigoClient\Enum\EndPoint\Invoice::STAMP_ERRORS,
            $entity
        );
    }

    /**
     * @param EntityInterface|null $entity
     * @return array
     */
    public function sendEmailsCopy(EntityInterface $entity = null): array
    {
        //set token before send request
        $response = [];
        $this->validator->validate(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::MAIL, $entity);
        $id = $entity->getAndRemove(AbstractValidator::URL_REQUEST);
        $body = $this->validator->getBody(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::MAIL, $entity);
        $headers = $this->getHeaders(['access_token' => $this->accessToken]);
        $entity->setData($id[AbstractValidator::URL_REQUEST]);
        $url = $this->validator->getUrl(\Srdorado\SiigoClient\Enum\EndPoint\Invoice::MAIL, $entity);
        $urlRequest = $this->getRequestUrl($url);
        $result = $this->post($urlRequest, $headers, json_encode($body));
        if ($result['code'] === 201) {
            $body = json_decode($result['contents'], true);
            $response = $body;
        } else {
            $message =  'response - ' . $result['contents'];
            throw new \Srdorado\SiigoClient\Exception\Rule\BadRequest($message);
        }
        return $response;
    }
}
