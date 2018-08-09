<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MySalesAgentApiTest extends TestCase
{
    use MakeMySalesAgentTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMySalesAgent()
    {
        $mySalesAgent = $this->fakeMySalesAgentData();
        $this->json('POST', '/api/v1/mySalesAgents', $mySalesAgent);

        $this->assertApiResponse($mySalesAgent);
    }

    /**
     * @test
     */
    public function testReadMySalesAgent()
    {
        $mySalesAgent = $this->makeMySalesAgent();
        $this->json('GET', '/api/v1/mySalesAgents/'.$mySalesAgent->id);

        $this->assertApiResponse($mySalesAgent->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMySalesAgent()
    {
        $mySalesAgent = $this->makeMySalesAgent();
        $editedMySalesAgent = $this->fakeMySalesAgentData();

        $this->json('PUT', '/api/v1/mySalesAgents/'.$mySalesAgent->id, $editedMySalesAgent);

        $this->assertApiResponse($editedMySalesAgent);
    }

    /**
     * @test
     */
    public function testDeleteMySalesAgent()
    {
        $mySalesAgent = $this->makeMySalesAgent();
        $this->json('DELETE', '/api/v1/mySalesAgents/'.$mySalesAgent->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/mySalesAgents/'.$mySalesAgent->id);

        $this->assertResponseStatus(404);
    }
}
