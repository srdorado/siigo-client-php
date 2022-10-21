<?php

namespace Srdorado\SiigoClient\Enum\Rule;

class Customer
{
    //USE UPDATE AND CREATE
    public const CREATE_BASIC_JSON = [
        'person_type' => Rule::SMALL_STRING . ':Person,Company',
        'id_type' => Rule::SMALL_STRING . ':13,31,22,42,50,R-00-PN,91,41,47,11,43,21,12', //Values in Colombia
        'identification' => Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':13',
        'name' => [
            '0' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30',
            '1' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30'
        ],
        'address' => [
            'address' => Rule::SMALL_STRING  . '|' . Rule::MAX_LENGTH . ':50',
            'city' => [
                'country_code' => Rule::SMALL_STRING  . '|' . Rule::MAX_LENGTH . ':3',
                'state_code' => Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':30',
                'city_code' => Rule::NUM_STRING  . '|' . Rule::MIN_LENGTH . ':5' .  '|' . Rule::MAX_LENGTH . ':8'
            ]
        ],
        'phones' => [
            [
                'number' =>  Rule::NUM_STRING  . '|' . Rule::LENGTH . ':10',
            ]
        ],
        'contacts' => [
            [
                'first_name' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30',
                'last_name' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30',
                'email' => Rule::E_MAIL
            ]
        ]
    ];

    public const CREATE_COMPLETE_JSON = [
        'type' => Rule::SMALL_STRING . ':Customer,Supplier,Other',
        'person_type' => Rule::SMALL_STRING . ':Person,Company',
        'id_type' => Rule::SMALL_STRING . ':13,31,22,42,50,R-00-PN,91,41,47,11,43,21,12', //Values in Colombia
        'identification' => Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':13',
        'name' => [
            '0' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30'
        ],
        'commercial_name' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30',
        'branch_office' => Rule::INT,
        'active' => Rule::BOOL,
        'vat_responsible' => Rule::BOOL,
        'address' => [
            'address' => Rule::SMALL_STRING  . '|' . Rule::MAX_LENGTH . ':50',
            'city' => [
                'country_code' => Rule::SMALL_STRING  . '|' . Rule::MAX_LENGTH . ':3',
                'state_code' => Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':30',
                'city_code' => Rule::NUM_STRING  . '|' . Rule::MIN_LENGTH . ':5' .  '|' . Rule::MAX_LENGTH . ':8'
            ]
        ],
        'phones' => [
            [
                'number' =>  Rule::NUM_STRING  . '|' . Rule::LENGTH . ':10',
            ]
        ],
        'contacts' => [
            [
                'first_name' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30',
                'last_name' => Rule::SMALL_STRING . '|' . Rule::MAX_LENGTH . ':30',
                'email' => Rule::E_MAIL,
                'phone' => [
                    [
                        'indicative' =>  Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':3',
                        'number' =>  Rule::NUM_STRING  . '|' . Rule::LENGTH . ':10',
                        'extension' =>  Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':3',
                    ]
                ],
            ]
        ],
        'comments' => Rule::SMALL_STRING  . '|' . Rule::MAX_LENGTH . ':150',
        'related_users' => [
            'seller_id' => Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':3',
            'collector_id' => Rule::NUM_STRING  . '|' . Rule::MAX_LENGTH . ':3',
        ],
    ];

    public const GET_BY_ID_PARAMS = [
        'customer_id' => Rule::STRING,
    ];

    public const DELETE_PARAMS = [
        'customer_id' => Rule::STRING,
    ];
}