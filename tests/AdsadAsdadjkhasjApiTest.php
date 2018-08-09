<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdsadAsdadjkhasjApiTest extends TestCase
{
    use MakeAdsadAsdadjkhasjTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->fakeAdsadAsdadjkhasjData();
        $this->json('POST', '/api/v1/adsadAsdadjkhasjs', $adsadAsdadjkhasj);

        $this->assertApiResponse($adsadAsdadjkhasj);
    }

    /**
     * @test
     */
    public function testReadAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->makeAdsadAsdadjkhasj();
        $this->json('GET', '/api/v1/adsadAsdadjkhasjs/'.$adsadAsdadjkhasj->id);

        $this->assertApiResponse($adsadAsdadjkhasj->toArray());
    }

    /**
     * @test
     */
    public function testUpdateAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->makeAdsadAsdadjkhasj();
        $editedAdsadAsdadjkhasj = $this->fakeAdsadAsdadjkhasjData();

        $this->json('PUT', '/api/v1/adsadAsdadjkhasjs/'.$adsadAsdadjkhasj->id, $editedAdsadAsdadjkhasj);

        $this->assertApiResponse($editedAdsadAsdadjkhasj);
    }

    /**
     * @test
     */
    public function testDeleteAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->makeAdsadAsdadjkhasj();
        $this->json('DELETE', '/api/v1/adsadAsdadjkhasjs/'.$adsadAsdadjkhasj->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/adsadAsdadjkhasjs/'.$adsadAsdadjkhasj->id);

        $this->assertResponseStatus(404);
    }
}
