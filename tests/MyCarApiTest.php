<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyCarApiTest extends TestCase
{
    use MakeMyCarTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateMyCar()
    {
        $myCar = $this->fakeMyCarData();
        $this->json('POST', '/api/v1/myCars', $myCar);

        $this->assertApiResponse($myCar);
    }

    /**
     * @test
     */
    public function testReadMyCar()
    {
        $myCar = $this->makeMyCar();
        $this->json('GET', '/api/v1/myCars/'.$myCar->id);

        $this->assertApiResponse($myCar->toArray());
    }

    /**
     * @test
     */
    public function testUpdateMyCar()
    {
        $myCar = $this->makeMyCar();
        $editedMyCar = $this->fakeMyCarData();

        $this->json('PUT', '/api/v1/myCars/'.$myCar->id, $editedMyCar);

        $this->assertApiResponse($editedMyCar);
    }

    /**
     * @test
     */
    public function testDeleteMyCar()
    {
        $myCar = $this->makeMyCar();
        $this->json('DELETE', '/api/v1/myCars/'.$myCar->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/myCars/'.$myCar->id);

        $this->assertResponseStatus(404);
    }
}
