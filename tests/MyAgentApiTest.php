<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyAgentApiTest extends TestCase
{
    use MakeMyAgentTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMyAgent()
    {
        $myAgent = $this->fakeMyAgentData();
        $this->json('POST', '/api/v1/myAgents', $myAgent);

        $this->assertApiResponse($myAgent);
    }

    /**
     * @test
     */
    public function testReadMyAgent()
    {
        $myAgent = $this->makeMyAgent();
        $this->json('GET', '/api/v1/myAgents/'.$myAgent->id);

        $this->assertApiResponse($myAgent->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMyAgent()
    {
        $myAgent = $this->makeMyAgent();
        $editedMyAgent = $this->fakeMyAgentData();

        $this->json('PUT', '/api/v1/myAgents/'.$myAgent->id, $editedMyAgent);

        $this->assertApiResponse($editedMyAgent);
    }

    /**
     * @test
     */
    public function testDeleteMyAgent()
    {
        $myAgent = $this->makeMyAgent();
        $this->json('DELETE', '/api/v1/myAgents/'.$myAgent->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/myAgents/'.$myAgent->id);

        $this->assertResponseStatus(404);
    }
}
