<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarBrandApiTest extends TestCase
{
    use MakeCarBrandTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarBrand()
    {
        $carBrand = $this->fakeCarBrandData();
        $this->json('POST', '/api/v1/carBrands', $carBrand);

        $this->assertApiResponse($carBrand);
    }

    /**
     * @test
     */
    public function testReadCarBrand()
    {
        $carBrand = $this->makeCarBrand();
        $this->json('GET', '/api/v1/carBrands/'.$carBrand->id);

        $this->assertApiResponse($carBrand->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarBrand()
    {
        $carBrand = $this->makeCarBrand();
        $editedCarBrand = $this->fakeCarBrandData();

        $this->json('PUT', '/api/v1/carBrands/'.$carBrand->id, $editedCarBrand);

        $this->assertApiResponse($editedCarBrand);
    }

    /**
     * @test
     */
    public function testDeleteCarBrand()
    {
        $carBrand = $this->makeCarBrand();
        $this->json('DELETE', '/api/v1/carBrands/'.$carBrand->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carBrands/'.$carBrand->id);

        $this->assertResponseStatus(404);
    }
}
