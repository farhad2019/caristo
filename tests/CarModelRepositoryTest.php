<?php

use App\Models\CarModel;
use App\Repositories\Admin\CarModelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarModelRepositoryTest extends TestCase
{
    use MakeCarModelTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarModelRepository
     */
    protected $carModelRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carModelRepo = App::make(CarModelRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarModel()
    {
        $carModel = $this->fakeCarModelData();
        $createdCarModel = $this->carModelRepo->create($carModel);
        $createdCarModel = $createdCarModel->toArray();
        $this->assertArrayHasKey('id', $createdCarModel);
        $this->assertNotNull($createdCarModel['id'], 'Created CarModel must have id specified');
        $this->assertNotNull(CarModel::find($createdCarModel['id']), 'CarModel with given id must be in DB');
        $this->assertModelData($carModel, $createdCarModel);
    }

    /**
     * @test read
     */
    public function testReadCarModel()
    {
        $carModel = $this->makeCarModel();
        $dbCarModel = $this->carModelRepo->find($carModel->id);
        $dbCarModel = $dbCarModel->toArray();
        $this->assertModelData($carModel->toArray(), $dbCarModel);
    }

    /**
     * @test update
     */
    public function testUpdateCarModel()
    {
        $carModel = $this->makeCarModel();
        $fakeCarModel = $this->fakeCarModelData();
        $updatedCarModel = $this->carModelRepo->update($fakeCarModel, $carModel->id);
        $this->assertModelData($fakeCarModel, $updatedCarModel->toArray());
        $dbCarModel = $this->carModelRepo->find($carModel->id);
        $this->assertModelData($fakeCarModel, $dbCarModel->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarModel()
    {
        $carModel = $this->makeCarModel();
        $resp = $this->carModelRepo->delete($carModel->id);
        $this->assertTrue($resp);
        $this->assertNull(CarModel::find($carModel->id), 'CarModel should not exist in DB');
    }
}
