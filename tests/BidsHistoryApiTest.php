<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BidsHistoryApiTest extends TestCase
{
    use MakeBidsHistoryTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateBidsHistory()
    {
        $bidsHistory = $this->fakeBidsHistoryData();
        $this->json('POST', '/api/v1/bidsHistories', $bidsHistory);

        $this->assertApiResponse($bidsHistory);
    }

    /**
     * @test
     */
    public function testReadBidsHistory()
    {
        $bidsHistory = $this->makeBidsHistory();
        $this->json('GET', '/api/v1/bidsHistories/'.$bidsHistory->id);

        $this->assertApiResponse($bidsHistory->toArray());
    }

    /**
     * @test
     */
    public function testUpdateBidsHistory()
    {
        $bidsHistory = $this->makeBidsHistory();
        $editedBidsHistory = $this->fakeBidsHistoryData();

        $this->json('PUT', '/api/v1/bidsHistories/'.$bidsHistory->id, $editedBidsHistory);

        $this->assertApiResponse($editedBidsHistory);
    }

    /**
     * @test
     */
    public function testDeleteBidsHistory()
    {
        $bidsHistory = $this->makeBidsHistory();
        $this->json('DELETE', '/api/v1/bidsHistories/'.$bidsHistory->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/bidsHistories/'.$bidsHistory->id);

        $this->assertResponseStatus(404);
    }
}
