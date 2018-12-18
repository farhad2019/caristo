<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TradeInCarApiTest extends TestCase
{
    use MakeTradeInCarTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTradeInCar()
    {
        $tradeInCar = $this->fakeTradeInCarData();
        $this->json('POST', '/api/v1/tradeInCars', $tradeInCar);

        $this->assertApiResponse($tradeInCar);
    }

    /**
     * @test
     */
    public function testReadTradeInCar()
    {
        $tradeInCar = $this->makeTradeInCar();
        $this->json('GET', '/api/v1/tradeInCars/'.$tradeInCar->id);

        $this->assertApiResponse($tradeInCar->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTradeInCar()
    {
        $tradeInCar = $this->makeTradeInCar();
        $editedTradeInCar = $this->fakeTradeInCarData();

        $this->json('PUT', '/api/v1/tradeInCars/'.$tradeInCar->id, $editedTradeInCar);

        $this->assertApiResponse($editedTradeInCar);
    }

    /**
     * @test
     */
    public function testDeleteTradeInCar()
    {
        $tradeInCar = $this->makeTradeInCar();
        $this->json('DELETE', '/api/v1/tradeInCars/'.$tradeInCar->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/tradeInCars/'.$tradeInCar->id);

        $this->assertResponseStatus(404);
    }
}
