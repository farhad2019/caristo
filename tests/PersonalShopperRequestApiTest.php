<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PersonalShopperRequestApiTest extends TestCase
{
    use MakePersonalShopperRequestTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatePersonalShopperRequest()
    {
        $personalShopperRequest = $this->fakePersonalShopperRequestData();
        $this->json('POST', '/api/v1/personalShopperRequests', $personalShopperRequest);

        $this->assertApiResponse($personalShopperRequest);
    }

    /**
     * @test
     */
    public function testReadPersonalShopperRequest()
    {
        $personalShopperRequest = $this->makePersonalShopperRequest();
        $this->json('GET', '/api/v1/personalShopperRequests/'.$personalShopperRequest->id);

        $this->assertApiResponse($personalShopperRequest->toArray());
    }

    /**
     * @test
     */
    public function testUpdatePersonalShopperRequest()
    {
        $personalShopperRequest = $this->makePersonalShopperRequest();
        $editedPersonalShopperRequest = $this->fakePersonalShopperRequestData();

        $this->json('PUT', '/api/v1/personalShopperRequests/'.$personalShopperRequest->id, $editedPersonalShopperRequest);

        $this->assertApiResponse($editedPersonalShopperRequest);
    }

    /**
     * @test
     */
    public function testDeletePersonalShopperRequest()
    {
        $personalShopperRequest = $this->makePersonalShopperRequest();
        $this->json('DELETE', '/api/v1/personalShopperRequests/'.$personalShopperRequest->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/personalShopperRequests/'.$personalShopperRequest->id);

        $this->assertResponseStatus(404);
    }
}
