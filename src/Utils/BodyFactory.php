<?php

namespace Srdorado\SiigoClient\Utils;

use Srdorado\SiigoClient\Model\EntityInterface;

class BodyFactory
{
    /**
     * @param EntityInterface $entity
     * @param array $rules
     * @return array
     */
    public function getBody(EntityInterface $entity, array $rules): array
    {
        return $this->merge($rules, $entity->getData(), []);
    }

    /**
     * @param array $rules
     * @param array $data
     * @return array
     */
    private function merge(array $rules, array $data): array
    {
        $body = [];

        foreach ($rules as $key => $rule) {
            $keyData = $key;

            if (is_numeric($key)) {
                $keyData = intval($key);
            }

            //TODO: vaidate second level and array array

            $body[$key] = $data[$keyData];
        }

        return $body;
    }
}
