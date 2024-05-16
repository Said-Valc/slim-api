<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class LoansApiTest extends TestCase
{
    public function setUp(): void
    {
        require dirname(__DIR__) . '/vendor/autoload.php';
    }
    public function testCreateLoan()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post('http://localhost:8000/loans', [
            'json' => [
                'amount' => 1000,
                'interest_rate' => 10,
                'term' => 30
            ]
        ]);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testGetLoanById()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('http://localhost:8000/loans/6');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testUpdateLoan()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->put('http://localhost:8000/loans/6', [
            'json' => [
                'amount' => 1200
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteLoan()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->delete('http://localhost:8000/loans/6');
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testGetListOfLoans()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('http://localhost:8000/loans');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testMain()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('http://localhost:8000/');
        $this->assertEquals(203, $response->getStatusCode());
    }
}
