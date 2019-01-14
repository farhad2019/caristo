<?php

use App\Models\ConsultancyRequest;
use App\Repositories\Admin\ConsultancyRequestRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConsultancyRequestRepositoryTest extends TestCase
{
    use MakeConsultancyRequestTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ConsultancyRequestRepository
     */
    protected $consultancyRequestRepo;

    public function setUp()
    {
        parent::setUp();
        $this->consultancyRequestRepo = App::make(ConsultancyRequestRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateConsultancyRequest()
    {
        $consultancyRequest = $this->fakeConsultancyRequestData();
        $createdConsultancyRequest = $this->consultancyRequestRepo->create($consultancyRequest);
        $createdConsultancyRequest = $createdConsultancyRequest->toArray();
        $this->assertArrayHasKey('id', $createdConsultancyRequest);
        $this->assertNotNull($createdConsultancyRequest['id'], 'Created ConsultancyRequest must have id specified');
        $this->assertNotNull(ConsultancyRequest::find($createdConsultancyRequest['id']), 'ConsultancyRequest with given id must be in DB');
        $this->assertModelData($consultancyRequest, $createdConsultancyRequest);
    }

    /**
     * @test read
     */
    public function testReadConsultancyRequest()
    {
        $consultancyRequest = $this->makeConsultancyRequest();
        $dbConsultancyRequest = $this->consultancyRequestRepo->find($consultancyRequest->id);
        $dbConsultancyRequest = $dbConsultancyRequest->toArray();
        $this->assertModelData($consultancyRequest->toArray(), $dbConsultancyRequest);
    }

    /**
     * @test update
     */
    public function testUpdateConsultancyRequest()
    {
        $consultancyRequest = $this->makeConsultancyRequest();
        $fakeConsultancyRequest = $this->fakeConsultancyRequestData();
        $updatedConsultancyRequest = $this->consultancyRequestRepo->update($fakeConsultancyRequest, $consultancyRequest->id);
        $this->assertModelData($fakeConsultancyRequest, $updatedConsultancyRequest->toArray());
        $dbConsultancyRequest = $this->consultancyRequestRepo->find($consultancyRequest->id);
        $this->assertModelData($fakeConsultancyRequest, $dbConsultancyRequest->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteConsultancyRequest()
    {
        $consultancyRequest = $this->makeConsultancyRequest();
        $resp = $this->consultancyRequestRepo->delete($consultancyRequest->id);
        $this->assertTrue($resp);
        $this->assertNull(ConsultancyRequest::find($consultancyRequest->id), 'ConsultancyRequest should not exist in DB');
    }
}
