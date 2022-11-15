<?php

namespace Srdorado\SiigoClient\Tests;

use PHPUnit\Framework\TestCase;

class ClientCustomerTest extends TestCase
{
    /**
     * @test
     */
    public function create()
    {
        // generate token
        $token = $this->getToken();

        // Create client
        $clientFactory = new \Srdorado\SiigoClient\Factory\ClientFactory();
        $clientCustomerFactory = $clientFactory->create(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);
        $clientCustomer = $clientCustomerFactory->create();
        $clientCustomer->setBaseUrl('https://api.siigo.com/');
        $clientCustomer->setAccessKey($token);

        $entity = new \Srdorado\SiigoClient\Model\Entity(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);

        $dataEntity = $this->getExampleCompleteClient();

        $entity->setData($dataEntity);

        $clientId = $clientCustomer->create($entity);

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function getAll()
    {
        // generate token
        $token = $this->getToken();

        // Create client
        $clientFactory = new \Srdorado\SiigoClient\Factory\ClientFactory();
        $clientCustomerFactory = $clientFactory->create(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);
        $clientCustomer = $clientCustomerFactory->create();
        $clientCustomer->setBaseUrl('https://api.siigo.com/');
        $clientCustomer->setAccessKey($token);

        $entity = new \Srdorado\SiigoClient\Model\Entity(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);

        $entity->setData(
            [
            'page' => 1,
            'page_size' => 25,
            ]
        );

        $clients = $clientCustomer->getAll($entity);

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function getById()
    {
        // generate token
        $token = $this->getToken();

        // Create client
        $clientFactory = new \Srdorado\SiigoClient\Factory\ClientFactory();
        $clientCustomerFactory = $clientFactory->create(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);
        $clientCustomer = $clientCustomerFactory->create();
        $clientCustomer->setBaseUrl('https://api.siigo.com/');
        $clientCustomer->setAccessKey($token);

        $entity = new \Srdorado\SiigoClient\Model\Entity(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);

        $entity->setData(
            [
                'customer_id' => '5700d7de-3f59-4ce5-93ac-c3a555e870e0'
            ]
        );

        $clientId = $clientCustomer->getById($entity);

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function update()
    {
        // generate token
        $token = $this->getToken();

        // Create client
        $clientFactory = new \Srdorado\SiigoClient\Factory\ClientFactory();
        $clientCustomerFactory = $clientFactory->create(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);
        $clientCustomer = $clientCustomerFactory->create();
        $clientCustomer->setBaseUrl('https://api.siigo.com/');
        $clientCustomer->setAccessKey($token);

        $entity = new \Srdorado\SiigoClient\Model\Entity(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);

        $dataEntity = $this->getExampleBasicClient();

        $dataEntity = array_merge(
            $dataEntity,
            [
                'url_request' => [
                    'customer_id' => '5700d7de-3f59-4ce5-93ac-c3a555e870e0'
                ]
            ]
        );

        $entity->setData($dataEntity);

        $clientId = $clientCustomer->update($entity);

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function delete()
    {
        // generate token
        $token = $this->getToken();

        // Create client
        $clientFactory = new \Srdorado\SiigoClient\Factory\ClientFactory();
        $clientCustomerFactory = $clientFactory->create(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);
        $clientCustomer = $clientCustomerFactory->create();
        $clientCustomer->setBaseUrl('https://api.siigo.com/');
        $clientCustomer->setAccessKey($token);

        $entity = new \Srdorado\SiigoClient\Model\Entity(\Srdorado\SiigoClient\Enum\ClientType::CUSTOMER);

        $entity->setData(
            [
                'customer_id' => '5700d7de-3f59-4ce5-93ac-c3a555e870e0'
            ]
        );

        $result = $clientCustomer->delete($entity);

        $this->assertTrue(true);
    }

    /**
     * Get token
     *
     * @return string
     * @throws \ReflectionException
     */
    private function getToken(): string
    {
        // Create client token
        $clientFactory = new \Srdorado\SiigoClient\Factory\ClientFactory();
        $clientTokenFactory = $clientFactory->create(\Srdorado\SiigoClient\Enum\ClientType::TOKEN);
        $clientToken = $clientTokenFactory->create();
        $clientToken->setBaseUrl('https://api.siigo.com/');

        // Create entity token
        $entity = new \Srdorado\SiigoClient\Model\Entity(\Srdorado\SiigoClient\Enum\ClientType::TOKEN);
        $entity->setData(
            [
                'username' => '',
                'access_key' => ''
            ]
        );

        // Request token
        return $clientToken->getToken($entity);
    }

    /**
     * Get data example basic client
     *
     * @return array
     */
    private function getExampleBasicClient(): array
    {
        return [
            'person_type' => 'Person',
            'id_type' => '13',
            'identification' => '28211310',
            'name' => [
                'Daniell',
                'Dorado'
            ],
            'address' => [
                'address' => 'Cra. 18 #79A - 42',
                'city' => [
                    'country_code' => 'Co',
                    'state_code' => '11',
                    'city_code' => '11001'
                ]
            ],
            'phones' => [
                [
                    'number' => '3006003344'
                ]
            ],
            'contacts' => [
                [
                    'first_name' => 'Daniel',
                    'last_name' => 'Dorado',
                    'email' => 'daniel.dorado@contacto.com',
                    'phone' => [
                        'indicative' => '57',
                        'number' => '3005003345',
                        'extension' => '132'
                    ]
                ]
            ]
        ];
    }

    /**
     * Get data example complete client
     *
     * @return array
     */
    private function getExampleCompleteClient(): array
    {
        return [
            'type' => 'Customer',
            'person_type' => 'Company',
            'id_type' => '31',
            'identification' => '38211180',
            'name' => [
                'Stark Industries'
            ],
            'commercial_name' => 'Industries',
            'branch_office' => 0,
            'active' => true,
            'vat_responsible' => true,
            'address' => [
                'address' => 'Cra. 18 #79A - 42',
                'city' => [
                    'country_code' => 'Co',
                    'state_code' => '11',
                    'city_code' => '11001'
                ],
                'postal_code' => '110911'
            ],
            'phones' => [
                [
                    'number' => '3006003344'
                ]
            ],
            'contacts' => [
                [
                    'first_name' => 'Marcos',
                    'last_name' => 'Castillo',
                    'email' => 'marcos.castillo@contacto.com',
                    'phone' => [
                        'indicative' => '57',
                        'number' => '3005003345',
                        'extension' => '132'
                    ]
                ],
                [
                    'first_name' => 'Marcos',
                    'last_name' => 'Castillo',
                    'email' => 'marcos.castillo@contacto.com',
                    'phone' => [
                        'indicative' => '57',
                        'number' => '3005003345',
                        'extension' => '132'
                    ]
                ]
            ],
            'comments' => '',
            'related_users' => [
                'seller_id' => 629,
                'collector_id' => 629
            ]
        ];
    }
}
