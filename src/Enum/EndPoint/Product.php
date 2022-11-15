<?php

namespace Srdorado\SiigoClient\Enum\EndPoint;

class Product
{
    public const CREATE = 'v1/products';
    public const GET_ALL = 'v1/products?page=%s&page_size=%s';
    public const GET_BY_ID = 'v1/products/%s';
    public const GET_BY_CODE = 'v1/products?code=%s';
    public const UPDATE = 'v1/products/%s';
    public const DELETE = 'v1/products/%s';

    public const HEADER_POST = [
        'Content-Type' => 'application/json',
        'Authorization' => ''
    ];
}
