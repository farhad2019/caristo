<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsInteractionApiTest extends TestCase
{
    use MakeNewsInteractionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateNewsInteraction()
    {
        $newsInteraction = $this->fakeNewsInteractionData();
        $this->json('POST', '/api/v1/newsInteractions', $newsInteraction);

        $this->assertApiResponse($newsInteraction);
    }

    /**
     * @test
     */
    public function testReadNewsInteraction()
    {
        $newsInteraction = $this->makeNewsInteraction();
        $this->json('GET', '/api/v1/newsInteractions/'.$newsInteraction->id);

        $this->assertApiResponse($newsInteraction->toArray());
    }

    /**
     * @test
     */
    public function testUpdateNewsInteraction()
    {
        $newsInteraction = $this->makeNewsInteraction();
        $editedNewsInteraction = $this->fakeNewsInteractionData();

        $this->json('PUT', '/api/v1/newsInteractions/'.$newsInteraction->id, $editedNewsInteraction);

        $this->assertApiResponse($editedNewsInteraction);
    }

    /**
     * @test
     */
    public function testDeleteNewsInteraction()
    {
        $newsInteraction = $this->makeNewsInteraction();
        $this->json('DELETE', '/api/v1/newsInteractions/'.$newsInteraction->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/newsInteractions/'.$newsInteraction->id);

        $this->assertResponseStatus(404);
    }
}
