<?php

namespace Srdorado\SiigoClient\Exception\Rule;

use Srdorado\SiigoClient\Exception\SiigoException;
use Throwable;

class BodyRuleRequestException extends SiigoException
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $defaultMessage =  ' malformed ruler or invalid paramaterals. ';
        $defaultMessage = $this->headMessage . $defaultMessage;
        $message = $defaultMessage . $message;
        $code = self::MALFORMED_RULE_OR_INVALID_PARAMS;
        parent::__construct($message, $code, $previous);
    }
}
