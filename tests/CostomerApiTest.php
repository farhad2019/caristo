<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CostomerApiTest extends TestCase
{
    use MakeCostomerTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCostomer()
    {
        $costomer = $this->fakeCostomerData();
        $this->json('POST', '/api/v1/costomers', $costomer);

        $this->assertApiResponse($costomer);
    }

    /**
     * @test
     */
    public function testReadCostomer()
    {
        $costomer = $this->makeCostomer();
        $this->json('GET', '/api/v1/costomers/'.$costomer->id);

        $this->assertApiResponse($costomer->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCostomer()
    {
        $costomer = $this->makeCostomer();
        $editedCostomer = $this->fakeCostomerData();

        $this->json('PUT', '/api/v1/costomers/'.$costomer->id, $editedCostomer);

        $this->assertApiResponse($editedCostomer);
    }

    /**
     * @test
     */
    public function testDeleteCostomer()
    {
        $costomer = $this->makeCostomer();
        $this->json('DELETE', '/api/v1/costomers/'.$costomer->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/costomers/'.$costomer->id);

        $this->assertResponseStatus(404);
    }
}
