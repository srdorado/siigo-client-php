<?php

namespace Srdorado\SiigoClient\Model\Validator;

use Srdorado\SiigoClient\Model\Entity;
use Srdorado\SiigoClient\Model\EntityInterface;

abstract class AbstractValidator
{
    public const URL_REQUEST = 'url_request';
    public const BODY_REQUEST = 'body_request';
    public const URL_BODY_REQUEST = 'url_body_request';

    protected $validator;

    protected $bodyFactory;

    protected $urlFactory;

    abstract public function validate(string $endPoint, EntityInterface $entity): void;

    abstract public function getBody(string $endPoint, EntityInterface $entity): array;

    abstract public function getUrl(string $endPoint, EntityInterface $entity): string;
}
