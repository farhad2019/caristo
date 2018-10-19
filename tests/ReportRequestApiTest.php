<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReportRequestApiTest extends TestCase
{
    use MakeReportRequestTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateReportRequest()
    {
        $reportRequest = $this->fakeReportRequestData();
        $this->json('POST', '/api/v1/reportRequests', $reportRequest);

        $this->assertApiResponse($reportRequest);
    }

    /**
     * @test
     */
    public function testReadReportRequest()
    {
        $reportRequest = $this->makeReportRequest();
        $this->json('GET', '/api/v1/reportRequests/'.$reportRequest->id);

        $this->assertApiResponse($reportRequest->toArray());
    }

    /**
     * @test
     */
    public function testUpdateReportRequest()
    {
        $reportRequest = $this->makeReportRequest();
        $editedReportRequest = $this->fakeReportRequestData();

        $this->json('PUT', '/api/v1/reportRequests/'.$reportRequest->id, $editedReportRequest);

        $this->assertApiResponse($editedReportRequest);
    }

    /**
     * @test
     */
    public function testDeleteReportRequest()
    {
        $reportRequest = $this->makeReportRequest();
        $this->json('DELETE', '/api/v1/reportRequests/'.$reportRequest->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/reportRequests/'.$reportRequest->id);

        $this->assertResponseStatus(404);
    }
}
