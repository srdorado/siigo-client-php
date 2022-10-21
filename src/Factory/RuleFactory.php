<?php

namespace Srdorado\SiigoClient\Factory;

class RuleFactory extends AbstractFactory
{
    private const RULES = [
        'email' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleEmailValidator::class,
        'num_string' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleNumStringValidator::class,
        'long_string' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleLongStringValidator::class,
        'string' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleStringValidator::class,
        'small_string' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleSmallStringValidator::class,
        'int' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleIntValidator::class,
        'bool' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleBoolValidator::class,
        'max_length' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleMaxLengthValidator::class,
        'min_length' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleMinLengthValidator::class,
        'length' => \Srdorado\SiigoClient\MOdel\RuleValidator\RuleLengthValidator::class
    ];

    protected string $class;

    public function __construct()
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function create(string $class = '', array $params = [])
    {
        $class = self::RULES[$class];
        return new \ReflectionClass($class);
    }
}
