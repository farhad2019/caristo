<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarTypeApiTest extends TestCase
{
    use MakeCarTypeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarType()
    {
        $carType = $this->fakeCarTypeData();
        $this->json('POST', '/api/v1/carTypes', $carType);

        $this->assertApiResponse($carType);
    }

    /**
     * @test
     */
    public function testReadCarType()
    {
        $carType = $this->makeCarType();
        $this->json('GET', '/api/v1/carTypes/'.$carType->id);

        $this->assertApiResponse($carType->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarType()
    {
        $carType = $this->makeCarType();
        $editedCarType = $this->fakeCarTypeData();

        $this->json('PUT', '/api/v1/carTypes/'.$carType->id, $editedCarType);

        $this->assertApiResponse($editedCarType);
    }

    /**
     * @test
     */
    public function testDeleteCarType()
    {
        $carType = $this->makeCarType();
        $this->json('DELETE', '/api/v1/carTypes/'.$carType->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carTypes/'.$carType->id);

        $this->assertResponseStatus(404);
    }
}
