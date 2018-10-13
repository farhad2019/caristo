<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MakeBidApiTest extends TestCase
{
    use MakeMakeBidTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMakeBid()
    {
        $makeBid = $this->fakeMakeBidData();
        $this->json('POST', '/api/v1/makeBids', $makeBid);

        $this->assertApiResponse($makeBid);
    }

    /**
     * @test
     */
    public function testReadMakeBid()
    {
        $makeBid = $this->makeMakeBid();
        $this->json('GET', '/api/v1/makeBids/'.$makeBid->id);

        $this->assertApiResponse($makeBid->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMakeBid()
    {
        $makeBid = $this->makeMakeBid();
        $editedMakeBid = $this->fakeMakeBidData();

        $this->json('PUT', '/api/v1/makeBids/'.$makeBid->id, $editedMakeBid);

        $this->assertApiResponse($editedMakeBid);
    }

    /**
     * @test
     */
    public function testDeleteMakeBid()
    {
        $makeBid = $this->makeMakeBid();
        $this->json('DELETE', '/api/v1/makeBids/'.$makeBid->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/makeBids/'.$makeBid->id);

        $this->assertResponseStatus(404);
    }
}
