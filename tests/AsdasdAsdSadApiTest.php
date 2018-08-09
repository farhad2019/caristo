<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AsdasdAsdSadApiTest extends TestCase
{
    use MakeAsdasdAsdSadTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->fakeAsdasdAsdSadData();
        $this->json('POST', '/api/v1/asdasdAsdSads', $asdasdAsdSad);

        $this->assertApiResponse($asdasdAsdSad);
    }

    /**
     * @test
     */
    public function testReadAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->makeAsdasdAsdSad();
        $this->json('GET', '/api/v1/asdasdAsdSads/'.$asdasdAsdSad->id);

        $this->assertApiResponse($asdasdAsdSad->toArray());
    }

    /**
     * @test
     */
    public function testUpdateAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->makeAsdasdAsdSad();
        $editedAsdasdAsdSad = $this->fakeAsdasdAsdSadData();

        $this->json('PUT', '/api/v1/asdasdAsdSads/'.$asdasdAsdSad->id, $editedAsdasdAsdSad);

        $this->assertApiResponse($editedAsdasdAsdSad);
    }

    /**
     * @test
     */
    public function testDeleteAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->makeAsdasdAsdSad();
        $this->json('DELETE', '/api/v1/asdasdAsdSads/'.$asdasdAsdSad->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/asdasdAsdSads/'.$asdasdAsdSad->id);

        $this->assertResponseStatus(404);
    }
}
