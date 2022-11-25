<?php

namespace Srdorado\SiigoClient\Enum;

class ClientType
{
    public const TOKEN = \Srdorado\SiigoClient\Factory\Client\ClientTokenFactory::class;
    public const PRODUCT = \Srdorado\SiigoClient\Factory\Client\ClientProductFactory::class;
    public const CUSTOMER = \Srdorado\SiigoClient\Factory\Client\ClientCustomerFactory::class;
    public const GENERIC = \Srdorado\SiigoClient\Factory\Client\ClientGenericFactory::class;
    public const INVOICE = \Srdorado\SiigoClient\Factory\Client\ClientInvoiceFactory::class;

    public const CREDIT_NOTE = '';
    public const VOUCHER = '';
    public const TAX = '';
    public const USER = '';
    public const COST_CENTER = '';
    public const FIXED_ASSET = '';
    public const JOURNAL_ENTRY = '';
}
