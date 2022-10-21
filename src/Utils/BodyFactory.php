<?php

namespace Srdorado\SiigoClient\Utils;

use Srdorado\SiigoClient\Model\EntityInterface;

class BodyFactory
{
    public function getBody(EntityInterface $entity, array $rules): array
    {
        return $this->merge($rules, $entity->getData(), []);
    }

    private function merge(array $rules, array $data): array
    {
        $body = [];

        foreach ($rules as $key => $rule) {
            $keyData = $key;

            if (is_numeric($key)) {
                $keyData = intval($key);
            }

            if (is_array($rule)) {
                $body['$key'] = $this->merge($rule, $data[$keyData]);
            }

            $body[$key] = $data[$keyData];
        }

        return $body;
    }
}
