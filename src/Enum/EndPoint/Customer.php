<?php

namespace Srdorado\SiigoClient\Enum\EndPoint;

class Customer
{
    public const CREATE = 'v1/customers';
    public const GET_ALL = 'v1/customers?page=%s&page_size=%s';
    public const GET_BY_ID = 'v1/customers/%s';
    public const UPDATE = 'v1/customers/%s';
    public const DELETE = 'v1/customers/%s';

    public const HEADER_POST = [
        'Content-Type' => 'application/json',
        'Authorization' => ''
    ];
}
