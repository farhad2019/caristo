<?php

use App\Models\Manager;
use App\Repositories\Admin\ManagerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagerRepositoryTest extends TestCase
{
    use MakeManagerTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ManagerRepository
     */
    protected $managerRepo;

    public function setUp()
    {
        parent::setUp();
        $this->managerRepo = App::make(ManagerRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateManager()
    {
        $manager = $this->fakeManagerData();
        $createdManager = $this->managerRepo->create($manager);
        $createdManager = $createdManager->toArray();
        $this->assertArrayHasKey('id', $createdManager);
        $this->assertNotNull($createdManager['id'], 'Created Manager must have id specified');
        $this->assertNotNull(Manager::find($createdManager['id']), 'Manager with given id must be in DB');
        $this->assertModelData($manager, $createdManager);
    }

    /**
     * @test read
     */
    public function testReadManager()
    {
        $manager = $this->makeManager();
        $dbManager = $this->managerRepo->find($manager->id);
        $dbManager = $dbManager->toArray();
        $this->assertModelData($manager->toArray(), $dbManager);
    }

    /**
     * @test update
     */
    public function testUpdateManager()
    {
        $manager = $this->makeManager();
        $fakeManager = $this->fakeManagerData();
        $updatedManager = $this->managerRepo->update($fakeManager, $manager->id);
        $this->assertModelData($fakeManager, $updatedManager->toArray());
        $dbManager = $this->managerRepo->find($manager->id);
        $this->assertModelData($fakeManager, $dbManager->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteManager()
    {
        $manager = $this->makeManager();
        $resp = $this->managerRepo->delete($manager->id);
        $this->assertTrue($resp);
        $this->assertNull(Manager::find($manager->id), 'Manager should not exist in DB');
    }
}
