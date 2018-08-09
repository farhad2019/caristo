<?php

use App\Models\Costomer;
use App\Repositories\Admin\CostomerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CostomerRepositoryTest extends TestCase
{
    use MakeCostomerTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CostomerRepository
     */
    protected $costomerRepo;

    public function setUp()
    {
        parent::setUp();
        $this->costomerRepo = App::make(CostomerRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCostomer()
    {
        $costomer = $this->fakeCostomerData();
        $createdCostomer = $this->costomerRepo->create($costomer);
        $createdCostomer = $createdCostomer->toArray();
        $this->assertArrayHasKey('id', $createdCostomer);
        $this->assertNotNull($createdCostomer['id'], 'Created Costomer must have id specified');
        $this->assertNotNull(Costomer::find($createdCostomer['id']), 'Costomer with given id must be in DB');
        $this->assertModelData($costomer, $createdCostomer);
    }

    /**
     * @test read
     */
    public function testReadCostomer()
    {
        $costomer = $this->makeCostomer();
        $dbCostomer = $this->costomerRepo->find($costomer->id);
        $dbCostomer = $dbCostomer->toArray();
        $this->assertModelData($costomer->toArray(), $dbCostomer);
    }

    /**
     * @test update
     */
    public function testUpdateCostomer()
    {
        $costomer = $this->makeCostomer();
        $fakeCostomer = $this->fakeCostomerData();
        $updatedCostomer = $this->costomerRepo->update($fakeCostomer, $costomer->id);
        $this->assertModelData($fakeCostomer, $updatedCostomer->toArray());
        $dbCostomer = $this->costomerRepo->find($costomer->id);
        $this->assertModelData($fakeCostomer, $dbCostomer->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCostomer()
    {
        $costomer = $this->makeCostomer();
        $resp = $this->costomerRepo->delete($costomer->id);
        $this->assertTrue($resp);
        $this->assertNull(Costomer::find($costomer->id), 'Costomer should not exist in DB');
    }
}
