<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EngineTypeApiTest extends TestCase
{
    use MakeEngineTypeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateEngineType()
    {
        $engineType = $this->fakeEngineTypeData();
        $this->json('POST', '/api/v1/engineTypes', $engineType);

        $this->assertApiResponse($engineType);
    }

    /**
     * @test
     */
    public function testReadEngineType()
    {
        $engineType = $this->makeEngineType();
        $this->json('GET', '/api/v1/engineTypes/'.$engineType->id);

        $this->assertApiResponse($engineType->toArray());
    }

    /**
     * @test
     */
    public function testUpdateEngineType()
    {
        $engineType = $this->makeEngineType();
        $editedEngineType = $this->fakeEngineTypeData();

        $this->json('PUT', '/api/v1/engineTypes/'.$engineType->id, $editedEngineType);

        $this->assertApiResponse($editedEngineType);
    }

    /**
     * @test
     */
    public function testDeleteEngineType()
    {
        $engineType = $this->makeEngineType();
        $this->json('DELETE', '/api/v1/engineTypes/'.$engineType->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/engineTypes/'.$engineType->id);

        $this->assertResponseStatus(404);
    }
}
