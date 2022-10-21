<?php

namespace Srdorado\SiigoClient\Model;

class Entity implements EntityInterface
{
    private string $clientType;

    private array $data;

    /**
     * @param string $clientType
     */
    public function __construct(string $clientType)
    {
        $this->clientType = $clientType;
        $this->data = [];
    }

    /**
     * @return string
     */
    public function getClientType(): string
    {
        return $this->clientType;
    }

    /**
     * @param string $clientType
     */
    public function setClientType(string $clientType): void
    {
        $this->clientType = $clientType;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param float|array|bool|int|string $value
     * @return void
     */
    public function addKeyValue(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @return int
     */
    public function countData(): int
    {
        return count($this->data);
    }
}