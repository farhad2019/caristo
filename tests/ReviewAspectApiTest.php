<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReviewAspectApiTest extends TestCase
{
    use MakeReviewAspectTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateReviewAspect()
    {
        $reviewAspect = $this->fakeReviewAspectData();
        $this->json('POST', '/api/v1/reviewAspects', $reviewAspect);

        $this->assertApiResponse($reviewAspect);
    }

    /**
     * @test
     */
    public function testReadReviewAspect()
    {
        $reviewAspect = $this->makeReviewAspect();
        $this->json('GET', '/api/v1/reviewAspects/'.$reviewAspect->id);

        $this->assertApiResponse($reviewAspect->toArray());
    }

    /**
     * @test
     */
    public function testUpdateReviewAspect()
    {
        $reviewAspect = $this->makeReviewAspect();
        $editedReviewAspect = $this->fakeReviewAspectData();

        $this->json('PUT', '/api/v1/reviewAspects/'.$reviewAspect->id, $editedReviewAspect);

        $this->assertApiResponse($editedReviewAspect);
    }

    /**
     * @test
     */
    public function testDeleteReviewAspect()
    {
        $reviewAspect = $this->makeReviewAspect();
        $this->json('DELETE', '/api/v1/reviewAspects/'.$reviewAspect->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/reviewAspects/'.$reviewAspect->id);

        $this->assertResponseStatus(404);
    }
}
