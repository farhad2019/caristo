<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarModelApiTest extends TestCase
{
    use MakeCarModelTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarModel()
    {
        $carModel = $this->fakeCarModelData();
        $this->json('POST', '/api/v1/carModels', $carModel);

        $this->assertApiResponse($carModel);
    }

    /**
     * @test
     */
    public function testReadCarModel()
    {
        $carModel = $this->makeCarModel();
        $this->json('GET', '/api/v1/carModels/'.$carModel->id);

        $this->assertApiResponse($carModel->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarModel()
    {
        $carModel = $this->makeCarModel();
        $editedCarModel = $this->fakeCarModelData();

        $this->json('PUT', '/api/v1/carModels/'.$carModel->id, $editedCarModel);

        $this->assertApiResponse($editedCarModel);
    }

    /**
     * @test
     */
    public function testDeleteCarModel()
    {
        $carModel = $this->makeCarModel();
        $this->json('DELETE', '/api/v1/carModels/'.$carModel->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carModels/'.$carModel->id);

        $this->assertResponseStatus(404);
    }
}
