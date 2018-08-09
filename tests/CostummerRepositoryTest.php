<?php

use App\Models\Costummer;
use App\Repositories\Admin\CostummerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CostummerRepositoryTest extends TestCase
{
    use MakeCostummerTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CostummerRepository
     */
    protected $costummerRepo;

    public function setUp()
    {
        parent::setUp();
        $this->costummerRepo = App::make(CostummerRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCostummer()
    {
        $costummer = $this->fakeCostummerData();
        $createdCostummer = $this->costummerRepo->create($costummer);
        $createdCostummer = $createdCostummer->toArray();
        $this->assertArrayHasKey('id', $createdCostummer);
        $this->assertNotNull($createdCostummer['id'], 'Created Costummer must have id specified');
        $this->assertNotNull(Costummer::find($createdCostummer['id']), 'Costummer with given id must be in DB');
        $this->assertModelData($costummer, $createdCostummer);
    }

    /**
     * @test read
     */
    public function testReadCostummer()
    {
        $costummer = $this->makeCostummer();
        $dbCostummer = $this->costummerRepo->find($costummer->id);
        $dbCostummer = $dbCostummer->toArray();
        $this->assertModelData($costummer->toArray(), $dbCostummer);
    }

    /**
     * @test update
     */
    public function testUpdateCostummer()
    {
        $costummer = $this->makeCostummer();
        $fakeCostummer = $this->fakeCostummerData();
        $updatedCostummer = $this->costummerRepo->update($fakeCostummer, $costummer->id);
        $this->assertModelData($fakeCostummer, $updatedCostummer->toArray());
        $dbCostummer = $this->costummerRepo->find($costummer->id);
        $this->assertModelData($fakeCostummer, $dbCostummer->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCostummer()
    {
        $costummer = $this->makeCostummer();
        $resp = $this->costummerRepo->delete($costummer->id);
        $this->assertTrue($resp);
        $this->assertNull(Costummer::find($costummer->id), 'Costummer should not exist in DB');
    }
}
