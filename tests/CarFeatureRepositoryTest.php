<?php

use App\Models\CarFeature;
use App\Repositories\Admin\CarFeatureRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarFeatureRepositoryTest extends TestCase
{
    use MakeCarFeatureTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarFeatureRepository
     */
    protected $carFeatureRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carFeatureRepo = App::make(CarFeatureRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarFeature()
    {
        $carFeature = $this->fakeCarFeatureData();
        $createdCarFeature = $this->carFeatureRepo->create($carFeature);
        $createdCarFeature = $createdCarFeature->toArray();
        $this->assertArrayHasKey('id', $createdCarFeature);
        $this->assertNotNull($createdCarFeature['id'], 'Created CarFeature must have id specified');
        $this->assertNotNull(CarFeature::find($createdCarFeature['id']), 'CarFeature with given id must be in DB');
        $this->assertModelData($carFeature, $createdCarFeature);
    }

    /**
     * @test read
     */
    public function testReadCarFeature()
    {
        $carFeature = $this->makeCarFeature();
        $dbCarFeature = $this->carFeatureRepo->find($carFeature->id);
        $dbCarFeature = $dbCarFeature->toArray();
        $this->assertModelData($carFeature->toArray(), $dbCarFeature);
    }

    /**
     * @test update
     */
    public function testUpdateCarFeature()
    {
        $carFeature = $this->makeCarFeature();
        $fakeCarFeature = $this->fakeCarFeatureData();
        $updatedCarFeature = $this->carFeatureRepo->update($fakeCarFeature, $carFeature->id);
        $this->assertModelData($fakeCarFeature, $updatedCarFeature->toArray());
        $dbCarFeature = $this->carFeatureRepo->find($carFeature->id);
        $this->assertModelData($fakeCarFeature, $dbCarFeature->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarFeature()
    {
        $carFeature = $this->makeCarFeature();
        $resp = $this->carFeatureRepo->delete($carFeature->id);
        $this->assertTrue($resp);
        $this->assertNull(CarFeature::find($carFeature->id), 'CarFeature should not exist in DB');
    }
}
