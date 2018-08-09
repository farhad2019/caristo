<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagerApiTest extends TestCase
{
    use MakeManagerTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateManager()
    {
        $manager = $this->fakeManagerData();
        $this->json('POST', '/api/v1/managers', $manager);

        $this->assertApiResponse($manager);
    }

    /**
     * @test
     */
    public function testReadManager()
    {
        $manager = $this->makeManager();
        $this->json('GET', '/api/v1/managers/'.$manager->id);

        $this->assertApiResponse($manager->toArray());
    }

    /**
     * @test
     */
    public function testUpdateManager()
    {
        $manager = $this->makeManager();
        $editedManager = $this->fakeManagerData();

        $this->json('PUT', '/api/v1/managers/'.$manager->id, $editedManager);

        $this->assertApiResponse($editedManager);
    }

    /**
     * @test
     */
    public function testDeleteManager()
    {
        $manager = $this->makeManager();
        $this->json('DELETE', '/api/v1/managers/'.$manager->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/managers/'.$manager->id);

        $this->assertResponseStatus(404);
    }
}
