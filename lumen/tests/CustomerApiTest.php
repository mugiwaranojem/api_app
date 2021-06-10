<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CustomerApiTest extends TestCase
{
    /**
     * /customers [GET]
     */
    public function testFetchCustomers()
    {
        
        $this->get('/customers');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'full_name',
                    'country'
                ]
            ],
        ]);
    }

    /**
     * /customers/{customerId} [GET]
     */
    public function testFetchCustomerDetail()
    {
        $this->get('/customers/2');
        $this->seeStatusCode(200);
        $this->seeJsonStructure(['data' =>
            [
                'full_name',
                'country',
                'email',
                'username',
                'gender',
                'city',
                'phone',
            ]
        ]);
    }
}
