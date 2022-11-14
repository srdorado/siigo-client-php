<?php

namespace Srdorado\SiigoClient\Factory;

class RuleFactory extends AbstractFactory
{
    private const RULES = [
        'email' => \Srdorado\SiigoClient\Model\RuleValidator\RuleEmailValidator::class,
        'num_string' => \Srdorado\SiigoClient\Model\RuleValidator\RuleNumStringValidator::class,
        'long_string' => \Srdorado\SiigoClient\Model\RuleValidator\RuleLongStringValidator::class,
        'string' => \Srdorado\SiigoClient\Model\RuleValidator\RuleStringValidator::class,
        'small_string' => \Srdorado\SiigoClient\Model\RuleValidator\RuleSmallStringValidator::class,
        'int' => \Srdorado\SiigoClient\Model\RuleValidator\RuleIntValidator::class,
        'bool' => \Srdorado\SiigoClient\Model\RuleValidator\RuleBoolValidator::class,
        'max_length' => \Srdorado\SiigoClient\Model\RuleValidator\RuleMaxLengthValidator::class,
        'min_length' => \Srdorado\SiigoClient\Model\RuleValidator\RuleMinLengthValidator::class,
        'length' => \Srdorado\SiigoClient\Model\RuleValidator\RuleLengthValidator::class
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

        $class = new \ReflectionClass($class);

        if (empty($params)) {
            // Create a new Instance without arguments:
            $instance = $class->newInstance();
        } else {
            // Create a new Instance with arguments
            $instance = $class->newInstanceArgs($params);
        }

        return $instance;
    }
}
