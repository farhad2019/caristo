<?php

use App\Models\CarBrand;
use App\Repositories\Admin\CarBrandRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarBrandRepositoryTest extends TestCase
{
    use MakeCarBrandTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarBrandRepository
     */
    protected $carBrandRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carBrandRepo = App::make(CarBrandRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarBrand()
    {
        $carBrand = $this->fakeCarBrandData();
        $createdCarBrand = $this->carBrandRepo->create($carBrand);
        $createdCarBrand = $createdCarBrand->toArray();
        $this->assertArrayHasKey('id', $createdCarBrand);
        $this->assertNotNull($createdCarBrand['id'], 'Created CarBrand must have id specified');
        $this->assertNotNull(CarBrand::find($createdCarBrand['id']), 'CarBrand with given id must be in DB');
        $this->assertModelData($carBrand, $createdCarBrand);
    }

    /**
     * @test read
     */
    public function testReadCarBrand()
    {
        $carBrand = $this->makeCarBrand();
        $dbCarBrand = $this->carBrandRepo->find($carBrand->id);
        $dbCarBrand = $dbCarBrand->toArray();
        $this->assertModelData($carBrand->toArray(), $dbCarBrand);
    }

    /**
     * @test update
     */
    public function testUpdateCarBrand()
    {
        $carBrand = $this->makeCarBrand();
        $fakeCarBrand = $this->fakeCarBrandData();
        $updatedCarBrand = $this->carBrandRepo->update($fakeCarBrand, $carBrand->id);
        $this->assertModelData($fakeCarBrand, $updatedCarBrand->toArray());
        $dbCarBrand = $this->carBrandRepo->find($carBrand->id);
        $this->assertModelData($fakeCarBrand, $dbCarBrand->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarBrand()
    {
        $carBrand = $this->makeCarBrand();
        $resp = $this->carBrandRepo->delete($carBrand->id);
        $this->assertTrue($resp);
        $this->assertNull(CarBrand::find($carBrand->id), 'CarBrand should not exist in DB');
    }
}
