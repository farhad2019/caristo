<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QwertyApiTest extends TestCase
{
    use MakeQwertyTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateQwerty()
    {
        $qwerty = $this->fakeQwertyData();
        $this->json('POST', '/api/v1/qwerties', $qwerty);

        $this->assertApiResponse($qwerty);
    }

    /**
     * @test
     */
    public function testReadQwerty()
    {
        $qwerty = $this->makeQwerty();
        $this->json('GET', '/api/v1/qwerties/'.$qwerty->id);

        $this->assertApiResponse($qwerty->toArray());
    }

    /**
     * @test
     */
    public function testUpdateQwerty()
    {
        $qwerty = $this->makeQwerty();
        $editedQwerty = $this->fakeQwertyData();

        $this->json('PUT', '/api/v1/qwerties/'.$qwerty->id, $editedQwerty);

        $this->assertApiResponse($editedQwerty);
    }

    /**
     * @test
     */
    public function testDeleteQwerty()
    {
        $qwerty = $this->makeQwerty();
        $this->json('DELETE', '/api/v1/qwerties/'.$qwerty->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/qwerties/'.$qwerty->id);

        $this->assertResponseStatus(404);
    }
}
