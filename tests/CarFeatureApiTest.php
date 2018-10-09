<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarFeatureApiTest extends TestCase
{
    use MakeCarFeatureTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarFeature()
    {
        $carFeature = $this->fakeCarFeatureData();
        $this->json('POST', '/api/v1/carFeatures', $carFeature);

        $this->assertApiResponse($carFeature);
    }

    /**
     * @test
     */
    public function testReadCarFeature()
    {
        $carFeature = $this->makeCarFeature();
        $this->json('GET', '/api/v1/carFeatures/'.$carFeature->id);

        $this->assertApiResponse($carFeature->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarFeature()
    {
        $carFeature = $this->makeCarFeature();
        $editedCarFeature = $this->fakeCarFeatureData();

        $this->json('PUT', '/api/v1/carFeatures/'.$carFeature->id, $editedCarFeature);

        $this->assertApiResponse($editedCarFeature);
    }

    /**
     * @test
     */
    public function testDeleteCarFeature()
    {
        $carFeature = $this->makeCarFeature();
        $this->json('DELETE', '/api/v1/carFeatures/'.$carFeature->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carFeatures/'.$carFeature->id);

        $this->assertResponseStatus(404);
    }
}
