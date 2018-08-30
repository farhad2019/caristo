<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WalkThroughApiTest extends TestCase
{
    use MakeWalkThroughTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateWalkThrough()
    {
        $walkThrough = $this->fakeWalkThroughData();
        $this->json('POST', '/api/v1/walkThroughs', $walkThrough);

        $this->assertApiResponse($walkThrough);
    }

    /**
     * @test
     */
    public function testReadWalkThrough()
    {
        $walkThrough = $this->makeWalkThrough();
        $this->json('GET', '/api/v1/walkThroughs/'.$walkThrough->id);

        $this->assertApiResponse($walkThrough->toArray());
    }

    /**
     * @test
     */
    public function testUpdateWalkThrough()
    {
        $walkThrough = $this->makeWalkThrough();
        $editedWalkThrough = $this->fakeWalkThroughData();

        $this->json('PUT', '/api/v1/walkThroughs/'.$walkThrough->id, $editedWalkThrough);

        $this->assertApiResponse($editedWalkThrough);
    }

    /**
     * @test
     */
    public function testDeleteWalkThrough()
    {
        $walkThrough = $this->makeWalkThrough();
        $this->json('DELETE', '/api/v1/walkThroughs/'.$walkThrough->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/walkThroughs/'.$walkThrough->id);

        $this->assertResponseStatus(404);
    }
}
