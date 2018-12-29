<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BanksRateApiTest extends TestCase
{
    use MakeBanksRateTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateBanksRate()
    {
        $banksRate = $this->fakeBanksRateData();
        $this->json('POST', '/api/v1/banksRates', $banksRate);

        $this->assertApiResponse($banksRate);
    }

    /**
     * @test
     */
    public function testReadBanksRate()
    {
        $banksRate = $this->makeBanksRate();
        $this->json('GET', '/api/v1/banksRates/'.$banksRate->id);

        $this->assertApiResponse($banksRate->toArray());
    }

    /**
     * @test
     */
    public function testUpdateBanksRate()
    {
        $banksRate = $this->makeBanksRate();
        $editedBanksRate = $this->fakeBanksRateData();

        $this->json('PUT', '/api/v1/banksRates/'.$banksRate->id, $editedBanksRate);

        $this->assertApiResponse($editedBanksRate);
    }

    /**
     * @test
     */
    public function testDeleteBanksRate()
    {
        $banksRate = $this->makeBanksRate();
        $this->json('DELETE', '/api/v1/banksRates/'.$banksRate->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/banksRates/'.$banksRate->id);

        $this->assertResponseStatus(404);
    }
}
