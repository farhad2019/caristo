<?php

use App\Models\MyAgent;
use App\Repositories\Admin\MyAgentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyAgentRepositoryTest extends TestCase
{
    use MakeMyAgentTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MyAgentRepository
     */
    protected $myAgentRepo;

    public function setUp()
    {
        parent::setUp();
        $this->myAgentRepo = App::make(MyAgentRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMyAgent()
    {
        $myAgent = $this->fakeMyAgentData();
        $createdMyAgent = $this->myAgentRepo->create($myAgent);
        $createdMyAgent = $createdMyAgent->toArray();
        $this->assertArrayHasKey('id', $createdMyAgent);
        $this->assertNotNull($createdMyAgent['id'], 'Created MyAgent must have id specified');
        $this->assertNotNull(MyAgent::find($createdMyAgent['id']), 'MyAgent with given id must be in DB');
        $this->assertModelData($myAgent, $createdMyAgent);
    }

    /**
     * @test read
     */
    public function testReadMyAgent()
    {
        $myAgent = $this->makeMyAgent();
        $dbMyAgent = $this->myAgentRepo->find($myAgent->id);
        $dbMyAgent = $dbMyAgent->toArray();
        $this->assertModelData($myAgent->toArray(), $dbMyAgent);
    }

    /**
     * @test update
     */
    public function testUpdateMyAgent()
    {
        $myAgent = $this->makeMyAgent();
        $fakeMyAgent = $this->fakeMyAgentData();
        $updatedMyAgent = $this->myAgentRepo->update($fakeMyAgent, $myAgent->id);
        $this->assertModelData($fakeMyAgent, $updatedMyAgent->toArray());
        $dbMyAgent = $this->myAgentRepo->find($myAgent->id);
        $this->assertModelData($fakeMyAgent, $dbMyAgent->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMyAgent()
    {
        $myAgent = $this->makeMyAgent();
        $resp = $this->myAgentRepo->delete($myAgent->id);
        $this->assertTrue($resp);
        $this->assertNull(MyAgent::find($myAgent->id), 'MyAgent should not exist in DB');
    }
}
