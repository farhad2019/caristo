<?php

use App\Models\CarAttribute;
use App\Repositories\Admin\CarAttributeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarAttributeRepositoryTest extends TestCase
{
    use MakeCarAttributeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarAttributeRepository
     */
    protected $carAttributeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carAttributeRepo = App::make(CarAttributeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarAttribute()
    {
        $carAttribute = $this->fakeCarAttributeData();
        $createdCarAttribute = $this->carAttributeRepo->create($carAttribute);
        $createdCarAttribute = $createdCarAttribute->toArray();
        $this->assertArrayHasKey('id', $createdCarAttribute);
        $this->assertNotNull($createdCarAttribute['id'], 'Created CarAttribute must have id specified');
        $this->assertNotNull(CarAttribute::find($createdCarAttribute['id']), 'CarAttribute with given id must be in DB');
        $this->assertModelData($carAttribute, $createdCarAttribute);
    }

    /**
     * @test read
     */
    public function testReadCarAttribute()
    {
        $carAttribute = $this->makeCarAttribute();
        $dbCarAttribute = $this->carAttributeRepo->find($carAttribute->id);
        $dbCarAttribute = $dbCarAttribute->toArray();
        $this->assertModelData($carAttribute->toArray(), $dbCarAttribute);
    }

    /**
     * @test update
     */
    public function testUpdateCarAttribute()
    {
        $carAttribute = $this->makeCarAttribute();
        $fakeCarAttribute = $this->fakeCarAttributeData();
        $updatedCarAttribute = $this->carAttributeRepo->update($fakeCarAttribute, $carAttribute->id);
        $this->assertModelData($fakeCarAttribute, $updatedCarAttribute->toArray());
        $dbCarAttribute = $this->carAttributeRepo->find($carAttribute->id);
        $this->assertModelData($fakeCarAttribute, $dbCarAttribute->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarAttribute()
    {
        $carAttribute = $this->makeCarAttribute();
        $resp = $this->carAttributeRepo->delete($carAttribute->id);
        $this->assertTrue($resp);
        $this->assertNull(CarAttribute::find($carAttribute->id), 'CarAttribute should not exist in DB');
    }
}
