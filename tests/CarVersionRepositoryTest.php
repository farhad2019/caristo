<?php

use App\Models\CarVersion;
use App\Repositories\Admin\CarVersionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarVersionRepositoryTest extends TestCase
{
    use MakeCarVersionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarVersionRepository
     */
    protected $carVersionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carVersionRepo = App::make(CarVersionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarVersion()
    {
        $carVersion = $this->fakeCarVersionData();
        $createdCarVersion = $this->carVersionRepo->create($carVersion);
        $createdCarVersion = $createdCarVersion->toArray();
        $this->assertArrayHasKey('id', $createdCarVersion);
        $this->assertNotNull($createdCarVersion['id'], 'Created CarVersion must have id specified');
        $this->assertNotNull(CarVersion::find($createdCarVersion['id']), 'CarVersion with given id must be in DB');
        $this->assertModelData($carVersion, $createdCarVersion);
    }

    /**
     * @test read
     */
    public function testReadCarVersion()
    {
        $carVersion = $this->makeCarVersion();
        $dbCarVersion = $this->carVersionRepo->find($carVersion->id);
        $dbCarVersion = $dbCarVersion->toArray();
        $this->assertModelData($carVersion->toArray(), $dbCarVersion);
    }

    /**
     * @test update
     */
    public function testUpdateCarVersion()
    {
        $carVersion = $this->makeCarVersion();
        $fakeCarVersion = $this->fakeCarVersionData();
        $updatedCarVersion = $this->carVersionRepo->update($fakeCarVersion, $carVersion->id);
        $this->assertModelData($fakeCarVersion, $updatedCarVersion->toArray());
        $dbCarVersion = $this->carVersionRepo->find($carVersion->id);
        $this->assertModelData($fakeCarVersion, $dbCarVersion->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarVersion()
    {
        $carVersion = $this->makeCarVersion();
        $resp = $this->carVersionRepo->delete($carVersion->id);
        $this->assertTrue($resp);
        $this->assertNull(CarVersion::find($carVersion->id), 'CarVersion should not exist in DB');
    }
}
