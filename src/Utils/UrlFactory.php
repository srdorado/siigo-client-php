<?php

namespace Srdorado\SiigoClient\Utils;

use Srdorado\SiigoClient\Model\EntityInterface;

class UrlFactory
{
    public function getUrl(string $endPoint, EntityInterface $entity): string
    {
        $url = $endPoint;

        if (strpos($url, '%s') === false) {
            return $endPoint;
        }

        foreach ($entity->getData() as $key => $value) {
            $url = \Srdorado\SiigoClient\Utils\Utils::replaceFirst($url, '%s', $value);
        }

        return $url;
    }
}
