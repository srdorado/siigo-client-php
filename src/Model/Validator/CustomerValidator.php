<?php

namespace Srdorado\SiigoClient\Model\Validator;

use Srdorado\SiigoClient\Enum\Rule\Customer as Rule;
use Srdorado\SiigoClient\Exception\Rule\UrlRuleRequestException;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Enum\EndPoint\Customer as EndPoint;

class CustomerValidator extends AbstractValidator
{
    /**
     * Construct
     */
    public function __construct()
    {
        $this->validator = new \Srdorado\SiigoClient\Utils\Validator();
        $this->bodyFactory = new \Srdorado\SiigoClient\Utils\BodyFactory();
        $this->urlFactory = new \Srdorado\SiigoClient\Utils\UrlFactory();
    }

    /**
     * @throws UrlRuleRequestException
     */
    public function validate(string $endPoint, EntityInterface $entity): void
    {
        switch ($endPoint) {
            case EndPoint::CREATE:
                // if complete or nomral
                $rule = Rule::CREATE_BASIC_JSON;
                if (count(Rule::CREATE_BASIC_JSON) != $entity->countData()) {
                    $rule = Rule::CREATE_COMPLETE_JSON;
                }
                $this->validator->validate(
                    AbstractValidator::BODY_REQUEST,
                    $entity,
                    $rule,
                    EndPoint::CREATE
                );
                //request body
                break;
            case EndPoint::UPDATE . 'U':
                //AbstractValidator::URL_REQUEST]
                $rule = Rule::CREATE_BASIC_JSON;
                if (count(Rule::CREATE_BASIC_JSON) != $entity->countData()) {
                    $rule = Rule::CREATE_COMPLETE_JSON;
                }
                $this->validator->validate(
                    AbstractValidator::URL_BODY_REQUEST,
                    $entity,
                    $rule,
                    EndPoint::UPDATE
                );
                break;
            case EndPoint::GET_ALL:
                $this->validator->validate(
                    AbstractValidator::URL_REQUEST,
                    $entity,
                    Rule::GET_ALL_PARAMS,
                    EndPoint::GET_ALL
                );
                //NO validation
                break;
            case EndPoint::GET_BY_ID:
                $this->validator->validate(
                    AbstractValidator::URL_REQUEST,
                    $entity,
                    Rule::GET_BY_ID_PARAMS,
                    EndPoint::GET_BY_ID
                );
                break;
            case EndPoint::DELETE . 'D':
                $this->validator->validate(
                    AbstractValidator::URL_REQUEST,
                    $entity,
                    Rule::DELETE_PARAMS,
                    EndPoint::DELETE
                );
                break;
            default:
                $message = ' endpoint does not exist.';
                throw new UrlRuleRequestException($message);
        }
    }

    /**
     * @param string $endPoint
     * @param EntityInterface $entity
     * @return array
     */
    public function getBody(string $endPoint, EntityInterface $entity): array
    {
        $rules = [];
        if ($endPoint === EndPoint::CREATE || $endPoint === EndPoint::UPDATE) {
            $rules = Rule::CREATE_BASIC_JSON;
            if (count(Rule::CREATE_COMPLETE_JSON) === $entity->countData()) {
                $rules = Rule::CREATE_COMPLETE_JSON;
            }
        }
        return $this->bodyFactory->getBody($entity, $rules);
    }

    /**
     * @param string $endPoint
     * @param EntityInterface $entity
     * @return string
     */
    public function getUrl(string $endPoint, EntityInterface $entity): string
    {
        return $this->urlFactory->getUrl($endPoint, $entity);
    }
}
