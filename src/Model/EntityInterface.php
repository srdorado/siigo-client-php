<?php

namespace Srdorado\SiigoClient\Model;

interface EntityInterface
{
    /**
     * @return string
     */
    public function getClientType(): string;

    /**
     * @param string $clientType
     */
    public function setClientType(string $clientType): void;

    /**
     * @return string
     */
    public function getRequestType(): string;

    /**
     * @param string $requestType
     */
    public function setRequestType(string $requestType): void;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @param array $data
     */
    public function setData(array $data): void;


    /**
     * @return int
     */
    public function countData(): int;

    /**
     * @param string $key
     * @param float|array|bool|int|string $value
     * @return void
     */
    public function addKeyValue(string $key, $value): void;
}
