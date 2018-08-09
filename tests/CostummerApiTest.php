<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CostummerApiTest extends TestCase
{
    use MakeCostummerTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCostummer()
    {
        $costummer = $this->fakeCostummerData();
        $this->json('POST', '/api/v1/costummers', $costummer);

        $this->assertApiResponse($costummer);
    }

    /**
     * @test
     */
    public function testReadCostummer()
    {
        $costummer = $this->makeCostummer();
        $this->json('GET', '/api/v1/costummers/'.$costummer->id);

        $this->assertApiResponse($costummer->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCostummer()
    {
        $costummer = $this->makeCostummer();
        $editedCostummer = $this->fakeCostummerData();

        $this->json('PUT', '/api/v1/costummers/'.$costummer->id, $editedCostummer);

        $this->assertApiResponse($editedCostummer);
    }

    /**
     * @test
     */
    public function testDeleteCostummer()
    {
        $costummer = $this->makeCostummer();
        $this->json('DELETE', '/api/v1/costummers/'.$costummer->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/costummers/'.$costummer->id);

        $this->assertResponseStatus(404);
    }
}
