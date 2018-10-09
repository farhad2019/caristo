<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegionApiTest extends TestCase
{
    use MakeRegionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRegion()
    {
        $region = $this->fakeRegionData();
        $this->json('POST', '/api/v1/regions', $region);

        $this->assertApiResponse($region);
    }

    /**
     * @test
     */
    public function testReadRegion()
    {
        $region = $this->makeRegion();
        $this->json('GET', '/api/v1/regions/'.$region->id);

        $this->assertApiResponse($region->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRegion()
    {
        $region = $this->makeRegion();
        $editedRegion = $this->fakeRegionData();

        $this->json('PUT', '/api/v1/regions/'.$region->id, $editedRegion);

        $this->assertApiResponse($editedRegion);
    }

    /**
     * @test
     */
    public function testDeleteRegion()
    {
        $region = $this->makeRegion();
        $this->json('DELETE', '/api/v1/regions/'.$region->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/regions/'.$region->id);

        $this->assertResponseStatus(404);
    }
}
