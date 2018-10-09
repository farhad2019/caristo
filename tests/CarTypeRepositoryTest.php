<?php

use App\Models\CarType;
use App\Repositories\Admin\CarTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarTypeRepositoryTest extends TestCase
{
    use MakeCarTypeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarTypeRepository
     */
    protected $carTypeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carTypeRepo = App::make(CarTypeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarType()
    {
        $carType = $this->fakeCarTypeData();
        $createdCarType = $this->carTypeRepo->create($carType);
        $createdCarType = $createdCarType->toArray();
        $this->assertArrayHasKey('id', $createdCarType);
        $this->assertNotNull($createdCarType['id'], 'Created CarType must have id specified');
        $this->assertNotNull(CarType::find($createdCarType['id']), 'CarType with given id must be in DB');
        $this->assertModelData($carType, $createdCarType);
    }

    /**
     * @test read
     */
    public function testReadCarType()
    {
        $carType = $this->makeCarType();
        $dbCarType = $this->carTypeRepo->find($carType->id);
        $dbCarType = $dbCarType->toArray();
        $this->assertModelData($carType->toArray(), $dbCarType);
    }

    /**
     * @test update
     */
    public function testUpdateCarType()
    {
        $carType = $this->makeCarType();
        $fakeCarType = $this->fakeCarTypeData();
        $updatedCarType = $this->carTypeRepo->update($fakeCarType, $carType->id);
        $this->assertModelData($fakeCarType, $updatedCarType->toArray());
        $dbCarType = $this->carTypeRepo->find($carType->id);
        $this->assertModelData($fakeCarType, $dbCarType->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarType()
    {
        $carType = $this->makeCarType();
        $resp = $this->carTypeRepo->delete($carType->id);
        $this->assertTrue($resp);
        $this->assertNull(CarType::find($carType->id), 'CarType should not exist in DB');
    }
}
