<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarVersionApiTest extends TestCase
{
    use MakeCarVersionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarVersion()
    {
        $carVersion = $this->fakeCarVersionData();
        $this->json('POST', '/api/v1/carVersions', $carVersion);

        $this->assertApiResponse($carVersion);
    }

    /**
     * @test
     */
    public function testReadCarVersion()
    {
        $carVersion = $this->makeCarVersion();
        $this->json('GET', '/api/v1/carVersions/'.$carVersion->id);

        $this->assertApiResponse($carVersion->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarVersion()
    {
        $carVersion = $this->makeCarVersion();
        $editedCarVersion = $this->fakeCarVersionData();

        $this->json('PUT', '/api/v1/carVersions/'.$carVersion->id, $editedCarVersion);

        $this->assertApiResponse($editedCarVersion);
    }

    /**
     * @test
     */
    public function testDeleteCarVersion()
    {
        $carVersion = $this->makeCarVersion();
        $this->json('DELETE', '/api/v1/carVersions/'.$carVersion->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carVersions/'.$carVersion->id);

        $this->assertResponseStatus(404);
    }
}
