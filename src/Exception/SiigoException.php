<?php

namespace Srdorado\SiigoClient\Exception;

class SiigoException extends \Exception
{
    protected const INCORRECT_NUMBER_PARAMETERS = 20001;
    protected const MALFORMED_RULE_OR_INVALID_PARAMS = 20002;

    protected string $headMessage = 'Siigo: ';
}
