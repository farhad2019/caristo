<?php

use App\Models\Region;
use App\Repositories\Admin\RegionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegionRepositoryTest extends TestCase
{
    use MakeRegionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var RegionRepository
     */
    protected $regionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->regionRepo = App::make(RegionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateRegion()
    {
        $region = $this->fakeRegionData();
        $createdRegion = $this->regionRepo->create($region);
        $createdRegion = $createdRegion->toArray();
        $this->assertArrayHasKey('id', $createdRegion);
        $this->assertNotNull($createdRegion['id'], 'Created Region must have id specified');
        $this->assertNotNull(Region::find($createdRegion['id']), 'Region with given id must be in DB');
        $this->assertModelData($region, $createdRegion);
    }

    /**
     * @test read
     */
    public function testReadRegion()
    {
        $region = $this->makeRegion();
        $dbRegion = $this->regionRepo->find($region->id);
        $dbRegion = $dbRegion->toArray();
        $this->assertModelData($region->toArray(), $dbRegion);
    }

    /**
     * @test update
     */
    public function testUpdateRegion()
    {
        $region = $this->makeRegion();
        $fakeRegion = $this->fakeRegionData();
        $updatedRegion = $this->regionRepo->update($fakeRegion, $region->id);
        $this->assertModelData($fakeRegion, $updatedRegion->toArray());
        $dbRegion = $this->regionRepo->find($region->id);
        $this->assertModelData($fakeRegion, $dbRegion->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteRegion()
    {
        $region = $this->makeRegion();
        $resp = $this->regionRepo->delete($region->id);
        $this->assertTrue($resp);
        $this->assertNull(Region::find($region->id), 'Region should not exist in DB');
    }
}
