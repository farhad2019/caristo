<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConsultancyRequestApiTest extends TestCase
{
    use MakeConsultancyRequestTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateConsultancyRequest()
    {
        $consultancyRequest = $this->fakeConsultancyRequestData();
        $this->json('POST', '/api/v1/consultancyRequests', $consultancyRequest);

        $this->assertApiResponse($consultancyRequest);
    }

    /**
     * @test
     */
    public function testReadConsultancyRequest()
    {
        $consultancyRequest = $this->makeConsultancyRequest();
        $this->json('GET', '/api/v1/consultancyRequests/'.$consultancyRequest->id);

        $this->assertApiResponse($consultancyRequest->toArray());
    }

    /**
     * @test
     */
    public function testUpdateConsultancyRequest()
    {
        $consultancyRequest = $this->makeConsultancyRequest();
        $editedConsultancyRequest = $this->fakeConsultancyRequestData();

        $this->json('PUT', '/api/v1/consultancyRequests/'.$consultancyRequest->id, $editedConsultancyRequest);

        $this->assertApiResponse($editedConsultancyRequest);
    }

    /**
     * @test
     */
    public function testDeleteConsultancyRequest()
    {
        $consultancyRequest = $this->makeConsultancyRequest();
        $this->json('DELETE', '/api/v1/consultancyRequests/'.$consultancyRequest->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/consultancyRequests/'.$consultancyRequest->id);

        $this->assertResponseStatus(404);
    }
}
