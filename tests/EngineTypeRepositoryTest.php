<?php

use App\Models\EngineType;
use App\Repositories\Admin\EngineTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EngineTypeRepositoryTest extends TestCase
{
    use MakeEngineTypeTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var EngineTypeRepository
     */
    protected $engineTypeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->engineTypeRepo = App::make(EngineTypeRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateEngineType()
    {
        $engineType = $this->fakeEngineTypeData();
        $createdEngineType = $this->engineTypeRepo->create($engineType);
        $createdEngineType = $createdEngineType->toArray();
        $this->assertArrayHasKey('id', $createdEngineType);
        $this->assertNotNull($createdEngineType['id'], 'Created EngineType must have id specified');
        $this->assertNotNull(EngineType::find($createdEngineType['id']), 'EngineType with given id must be in DB');
        $this->assertModelData($engineType, $createdEngineType);
    }

    /**
     * @test read
     */
    public function testReadEngineType()
    {
        $engineType = $this->makeEngineType();
        $dbEngineType = $this->engineTypeRepo->find($engineType->id);
        $dbEngineType = $dbEngineType->toArray();
        $this->assertModelData($engineType->toArray(), $dbEngineType);
    }

    /**
     * @test update
     */
    public function testUpdateEngineType()
    {
        $engineType = $this->makeEngineType();
        $fakeEngineType = $this->fakeEngineTypeData();
        $updatedEngineType = $this->engineTypeRepo->update($fakeEngineType, $engineType->id);
        $this->assertModelData($fakeEngineType, $updatedEngineType->toArray());
        $dbEngineType = $this->engineTypeRepo->find($engineType->id);
        $this->assertModelData($fakeEngineType, $dbEngineType->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteEngineType()
    {
        $engineType = $this->makeEngineType();
        $resp = $this->engineTypeRepo->delete($engineType->id);
        $this->assertTrue($resp);
        $this->assertNull(EngineType::find($engineType->id), 'EngineType should not exist in DB');
    }
}
