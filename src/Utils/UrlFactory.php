<?php

namespace Srdorado\SiigoClient\Utils;

use Srdorado\SiigoClient\Model\EntityInterface;

class UrlFactory
{
    public function getUrl(string $endPoint, EntityInterface $entity): string
    {
        $url = '';

        foreach ($entity->getData() as $key => $value) {
            $url = \Srdorado\SiigoClient\Utils\Utils::replaceFirst($url, '%s', $value);
        }

        return $url;
    }
}
