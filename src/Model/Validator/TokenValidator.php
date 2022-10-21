<?php

namespace Srdorado\SiigoClient\Model\Validator;

use Srdorado\SiigoClient\Enum\Rule\Token;
use Srdorado\SiigoClient\Exception\Rule\UrlRuleRequestException;
use Srdorado\SiigoClient\Model\EntityInterface;
use Srdorado\SiigoClient\Enum\EndPoint\Token as EndPointToken;

class TokenValidator extends AbstractValidator
{
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
        if (\Srdorado\SiigoClient\Enum\EndPoint\Token::AUTH !== $endPoint) {
            $message = ' endpoint does not exist.';
            throw new UrlRuleRequestException($message);
        }

        $this->validator->validate(AbstractValidator::BODY_REQUEST, $entity, Token::AUTH, EndPointToken::AUTH);
    }

    /**
     * @param string $endPoint
     * @param EntityInterface $entity
     * @return array
     */
    public function getBody(string $endPoint, EntityInterface $entity): array
    {
        $rules = [];

        if (\Srdorado\SiigoClient\Enum\EndPoint\Token::AUTH === $endPoint) {
            $rules = \Srdorado\SiigoClient\Enum\Rule\Token::AUTH;
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
        $this->urlFactory->getUrl($endPoint, $entity);
    }
}
