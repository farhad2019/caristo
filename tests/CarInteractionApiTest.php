<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarInteractionApiTest extends TestCase
{
    use MakeCarInteractionTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarInteraction()
    {
        $carInteraction = $this->fakeCarInteractionData();
        $this->json('POST', '/api/v1/carInteractions', $carInteraction);

        $this->assertApiResponse($carInteraction);
    }

    /**
     * @test
     */
    public function testReadCarInteraction()
    {
        $carInteraction = $this->makeCarInteraction();
        $this->json('GET', '/api/v1/carInteractions/'.$carInteraction->id);

        $this->assertApiResponse($carInteraction->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarInteraction()
    {
        $carInteraction = $this->makeCarInteraction();
        $editedCarInteraction = $this->fakeCarInteractionData();

        $this->json('PUT', '/api/v1/carInteractions/'.$carInteraction->id, $editedCarInteraction);

        $this->assertApiResponse($editedCarInteraction);
    }

    /**
     * @test
     */
    public function testDeleteCarInteraction()
    {
        $carInteraction = $this->makeCarInteraction();
        $this->json('DELETE', '/api/v1/carInteractions/'.$carInteraction->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carInteractions/'.$carInteraction->id);

        $this->assertResponseStatus(404);
    }
}
