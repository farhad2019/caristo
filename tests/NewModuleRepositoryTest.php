<?php

use App\Models\NewModule;
use App\Repositories\Admin\NewModuleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewModuleRepositoryTest extends TestCase
{
    use MakeNewModuleTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var NewModuleRepository
     */
    protected $newModuleRepo;

    public function setUp()
    {
        parent::setUp();
        $this->newModuleRepo = App::make(NewModuleRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateNewModule()
    {
        $newModule = $this->fakeNewModuleData();
        $createdNewModule = $this->newModuleRepo->create($newModule);
        $createdNewModule = $createdNewModule->toArray();
        $this->assertArrayHasKey('id', $createdNewModule);
        $this->assertNotNull($createdNewModule['id'], 'Created NewModule must have id specified');
        $this->assertNotNull(NewModule::find($createdNewModule['id']), 'NewModule with given id must be in DB');
        $this->assertModelData($newModule, $createdNewModule);
    }

    /**
     * @test read
     */
    public function testReadNewModule()
    {
        $newModule = $this->makeNewModule();
        $dbNewModule = $this->newModuleRepo->find($newModule->id);
        $dbNewModule = $dbNewModule->toArray();
        $this->assertModelData($newModule->toArray(), $dbNewModule);
    }

    /**
     * @test update
     */
    public function testUpdateNewModule()
    {
        $newModule = $this->makeNewModule();
        $fakeNewModule = $this->fakeNewModuleData();
        $updatedNewModule = $this->newModuleRepo->update($fakeNewModule, $newModule->id);
        $this->assertModelData($fakeNewModule, $updatedNewModule->toArray());
        $dbNewModule = $this->newModuleRepo->find($newModule->id);
        $this->assertModelData($fakeNewModule, $dbNewModule->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteNewModule()
    {
        $newModule = $this->makeNewModule();
        $resp = $this->newModuleRepo->delete($newModule->id);
        $this->assertTrue($resp);
        $this->assertNull(NewModule::find($newModule->id), 'NewModule should not exist in DB');
    }
}
