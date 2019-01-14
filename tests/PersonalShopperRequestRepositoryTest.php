<?php

use App\Models\PersonalShopperRequest;
use App\Repositories\Admin\PersonalShopperRequestRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PersonalShopperRequestRepositoryTest extends TestCase
{
    use MakePersonalShopperRequestTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var PersonalShopperRequestRepository
     */
    protected $personalShopperRequestRepo;

    public function setUp()
    {
        parent::setUp();
        $this->personalShopperRequestRepo = App::make(PersonalShopperRequestRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatePersonalShopperRequest()
    {
        $personalShopperRequest = $this->fakePersonalShopperRequestData();
        $createdPersonalShopperRequest = $this->personalShopperRequestRepo->create($personalShopperRequest);
        $createdPersonalShopperRequest = $createdPersonalShopperRequest->toArray();
        $this->assertArrayHasKey('id', $createdPersonalShopperRequest);
        $this->assertNotNull($createdPersonalShopperRequest['id'], 'Created PersonalShopperRequest must have id specified');
        $this->assertNotNull(PersonalShopperRequest::find($createdPersonalShopperRequest['id']), 'PersonalShopperRequest with given id must be in DB');
        $this->assertModelData($personalShopperRequest, $createdPersonalShopperRequest);
    }

    /**
     * @test read
     */
    public function testReadPersonalShopperRequest()
    {
        $personalShopperRequest = $this->makePersonalShopperRequest();
        $dbPersonalShopperRequest = $this->personalShopperRequestRepo->find($personalShopperRequest->id);
        $dbPersonalShopperRequest = $dbPersonalShopperRequest->toArray();
        $this->assertModelData($personalShopperRequest->toArray(), $dbPersonalShopperRequest);
    }

    /**
     * @test update
     */
    public function testUpdatePersonalShopperRequest()
    {
        $personalShopperRequest = $this->makePersonalShopperRequest();
        $fakePersonalShopperRequest = $this->fakePersonalShopperRequestData();
        $updatedPersonalShopperRequest = $this->personalShopperRequestRepo->update($fakePersonalShopperRequest, $personalShopperRequest->id);
        $this->assertModelData($fakePersonalShopperRequest, $updatedPersonalShopperRequest->toArray());
        $dbPersonalShopperRequest = $this->personalShopperRequestRepo->find($personalShopperRequest->id);
        $this->assertModelData($fakePersonalShopperRequest, $dbPersonalShopperRequest->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletePersonalShopperRequest()
    {
        $personalShopperRequest = $this->makePersonalShopperRequest();
        $resp = $this->personalShopperRequestRepo->delete($personalShopperRequest->id);
        $this->assertTrue($resp);
        $this->assertNull(PersonalShopperRequest::find($personalShopperRequest->id), 'PersonalShopperRequest should not exist in DB');
    }
}
