<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarAttributeApiTest extends TestCase
{
    use MakeCarAttributeTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarAttribute()
    {
        $carAttribute = $this->fakeCarAttributeData();
        $this->json('POST', '/api/v1/carAttributes', $carAttribute);

        $this->assertApiResponse($carAttribute);
    }

    /**
     * @test
     */
    public function testReadCarAttribute()
    {
        $carAttribute = $this->makeCarAttribute();
        $this->json('GET', '/api/v1/carAttributes/'.$carAttribute->id);

        $this->assertApiResponse($carAttribute->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarAttribute()
    {
        $carAttribute = $this->makeCarAttribute();
        $editedCarAttribute = $this->fakeCarAttributeData();

        $this->json('PUT', '/api/v1/carAttributes/'.$carAttribute->id, $editedCarAttribute);

        $this->assertApiResponse($editedCarAttribute);
    }

    /**
     * @test
     */
    public function testDeleteCarAttribute()
    {
        $carAttribute = $this->makeCarAttribute();
        $this->json('DELETE', '/api/v1/carAttributes/'.$carAttribute->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carAttributes/'.$carAttribute->id);

        $this->assertResponseStatus(404);
    }
}
