<?php

use App\Models\MySalesAgent;
use App\Repositories\Admin\MySalesAgentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MySalesAgentRepositoryTest extends TestCase
{
    use MakeMySalesAgentTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MySalesAgentRepository
     */
    protected $mySalesAgentRepo;

    public function setUp()
    {
        parent::setUp();
        $this->mySalesAgentRepo = App::make(MySalesAgentRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMySalesAgent()
    {
        $mySalesAgent = $this->fakeMySalesAgentData();
        $createdMySalesAgent = $this->mySalesAgentRepo->create($mySalesAgent);
        $createdMySalesAgent = $createdMySalesAgent->toArray();
        $this->assertArrayHasKey('id', $createdMySalesAgent);
        $this->assertNotNull($createdMySalesAgent['id'], 'Created MySalesAgent must have id specified');
        $this->assertNotNull(MySalesAgent::find($createdMySalesAgent['id']), 'MySalesAgent with given id must be in DB');
        $this->assertModelData($mySalesAgent, $createdMySalesAgent);
    }

    /**
     * @test read
     */
    public function testReadMySalesAgent()
    {
        $mySalesAgent = $this->makeMySalesAgent();
        $dbMySalesAgent = $this->mySalesAgentRepo->find($mySalesAgent->id);
        $dbMySalesAgent = $dbMySalesAgent->toArray();
        $this->assertModelData($mySalesAgent->toArray(), $dbMySalesAgent);
    }

    /**
     * @test update
     */
    public function testUpdateMySalesAgent()
    {
        $mySalesAgent = $this->makeMySalesAgent();
        $fakeMySalesAgent = $this->fakeMySalesAgentData();
        $updatedMySalesAgent = $this->mySalesAgentRepo->update($fakeMySalesAgent, $mySalesAgent->id);
        $this->assertModelData($fakeMySalesAgent, $updatedMySalesAgent->toArray());
        $dbMySalesAgent = $this->mySalesAgentRepo->find($mySalesAgent->id);
        $this->assertModelData($fakeMySalesAgent, $dbMySalesAgent->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMySalesAgent()
    {
        $mySalesAgent = $this->makeMySalesAgent();
        $resp = $this->mySalesAgentRepo->delete($mySalesAgent->id);
        $this->assertTrue($resp);
        $this->assertNull(MySalesAgent::find($mySalesAgent->id), 'MySalesAgent should not exist in DB');
    }
}
