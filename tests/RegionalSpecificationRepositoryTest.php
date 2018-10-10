<?php

use App\Models\RegionalSpecification;
use App\Repositories\Admin\RegionalSpecificationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegionalSpecificationRepositoryTest extends TestCase
{
    use MakeRegionalSpecificationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RegionalSpecificationRepository
     */
    protected $regionalSpecificationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->regionalSpecificationRepo = App::make(RegionalSpecificationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRegionalSpecification()
    {
        $regionalSpecification = $this->fakeRegionalSpecificationData();
        $createdRegionalSpecification = $this->regionalSpecificationRepo->create($regionalSpecification);
        $createdRegionalSpecification = $createdRegionalSpecification->toArray();
        $this->assertArrayHasKey('id', $createdRegionalSpecification);
        $this->assertNotNull($createdRegionalSpecification['id'], 'Created RegionalSpecification must have id specified');
        $this->assertNotNull(RegionalSpecification::find($createdRegionalSpecification['id']), 'RegionalSpecification with given id must be in DB');
        $this->assertModelData($regionalSpecification, $createdRegionalSpecification);
    }

    /**
     * @test read
     */
    public function testReadRegionalSpecification()
    {
        $regionalSpecification = $this->makeRegionalSpecification();
        $dbRegionalSpecification = $this->regionalSpecificationRepo->find($regionalSpecification->id);
        $dbRegionalSpecification = $dbRegionalSpecification->toArray();
        $this->assertModelData($regionalSpecification->toArray(), $dbRegionalSpecification);
    }

    /**
     * @test update
     */
    public function testUpdateRegionalSpecification()
    {
        $regionalSpecification = $this->makeRegionalSpecification();
        $fakeRegionalSpecification = $this->fakeRegionalSpecificationData();
        $updatedRegionalSpecification = $this->regionalSpecificationRepo->update($fakeRegionalSpecification, $regionalSpecification->id);
        $this->assertModelData($fakeRegionalSpecification, $updatedRegionalSpecification->toArray());
        $dbRegionalSpecification = $this->regionalSpecificationRepo->find($regionalSpecification->id);
        $this->assertModelData($fakeRegionalSpecification, $dbRegionalSpecification->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRegionalSpecification()
    {
        $regionalSpecification = $this->makeRegionalSpecification();
        $resp = $this->regionalSpecificationRepo->delete($regionalSpecification->id);
        $this->assertTrue($resp);
        $this->assertNull(RegionalSpecification::find($regionalSpecification->id), 'RegionalSpecification should not exist in DB');
    }
}
