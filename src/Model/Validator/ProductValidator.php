<?php

namespace Srdorado\SiigoClient\Model\Validator;

use Srdorado\SiigoClient\Model\EntityInterface;

class ProductValidator extends AbstractValidator
{
    public function __construct()
    {
        $this->validator = new \Srdorado\SiigoClient\Utils\Validator();
        $this->bodyFactory = new \Srdorado\SiigoClient\Utils\BodyFactory();
        $this->urlFactory = new \Srdorado\SiigoClient\Utils\UrlFactory();
    }

    public function validate(string $endPoint, EntityInterface $entity): void
    {
        // TODO: Implement validate() method.
    }

    public function getBody(string $endPoint, EntityInterface $entity): array
    {
        // TODO: Implement getBody() method.
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
