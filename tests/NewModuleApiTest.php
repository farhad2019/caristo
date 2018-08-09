<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewModuleApiTest extends TestCase
{
    use MakeNewModuleTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateNewModule()
    {
        $newModule = $this->fakeNewModuleData();
        $this->json('POST', '/api/v1/newModules', $newModule);

        $this->assertApiResponse($newModule);
    }

    /**
     * @test
     */
    public function testReadNewModule()
    {
        $newModule = $this->makeNewModule();
        $this->json('GET', '/api/v1/newModules/'.$newModule->id);

        $this->assertApiResponse($newModule->toArray());
    }

    /**
     * @test
     */
    public function testUpdateNewModule()
    {
        $newModule = $this->makeNewModule();
        $editedNewModule = $this->fakeNewModuleData();

        $this->json('PUT', '/api/v1/newModules/'.$newModule->id, $editedNewModule);

        $this->assertApiResponse($editedNewModule);
    }

    /**
     * @test
     */
    public function testDeleteNewModule()
    {
        $newModule = $this->makeNewModule();
        $this->json('DELETE', '/api/v1/newModules/'.$newModule->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/newModules/'.$newModule->id);

        $this->assertResponseStatus(404);
    }
}
