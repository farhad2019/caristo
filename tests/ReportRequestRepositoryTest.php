<?php

use App\Models\ReportRequest;
use App\Repositories\Admin\ReportRequestRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReportRequestRepositoryTest extends TestCase
{
    use MakeReportRequestTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ReportRequestRepository
     */
    protected $reportRequestRepo;

    public function setUp()
    {
        parent::setUp();
        $this->reportRequestRepo = App::make(ReportRequestRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateReportRequest()
    {
        $reportRequest = $this->fakeReportRequestData();
        $createdReportRequest = $this->reportRequestRepo->create($reportRequest);
        $createdReportRequest = $createdReportRequest->toArray();
        $this->assertArrayHasKey('id', $createdReportRequest);
        $this->assertNotNull($createdReportRequest['id'], 'Created ReportRequest must have id specified');
        $this->assertNotNull(ReportRequest::find($createdReportRequest['id']), 'ReportRequest with given id must be in DB');
        $this->assertModelData($reportRequest, $createdReportRequest);
    }

    /**
     * @test read
     */
    public function testReadReportRequest()
    {
        $reportRequest = $this->makeReportRequest();
        $dbReportRequest = $this->reportRequestRepo->find($reportRequest->id);
        $dbReportRequest = $dbReportRequest->toArray();
        $this->assertModelData($reportRequest->toArray(), $dbReportRequest);
    }

    /**
     * @test update
     */
    public function testUpdateReportRequest()
    {
        $reportRequest = $this->makeReportRequest();
        $fakeReportRequest = $this->fakeReportRequestData();
        $updatedReportRequest = $this->reportRequestRepo->update($fakeReportRequest, $reportRequest->id);
        $this->assertModelData($fakeReportRequest, $updatedReportRequest->toArray());
        $dbReportRequest = $this->reportRequestRepo->find($reportRequest->id);
        $this->assertModelData($fakeReportRequest, $dbReportRequest->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteReportRequest()
    {
        $reportRequest = $this->makeReportRequest();
        $resp = $this->reportRequestRepo->delete($reportRequest->id);
        $this->assertTrue($resp);
        $this->assertNull(ReportRequest::find($reportRequest->id), 'ReportRequest should not exist in DB');
    }
}
