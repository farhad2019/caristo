<?php

use App\Models\NewsInteraction;
use App\Repositories\Admin\NewsInteractionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsInteractionRepositoryTest extends TestCase
{
    use MakeNewsInteractionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var NewsInteractionRepository
     */
    protected $newsInteractionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->newsInteractionRepo = App::make(NewsInteractionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateNewsInteraction()
    {
        $newsInteraction = $this->fakeNewsInteractionData();
        $createdNewsInteraction = $this->newsInteractionRepo->create($newsInteraction);
        $createdNewsInteraction = $createdNewsInteraction->toArray();
        $this->assertArrayHasKey('id', $createdNewsInteraction);
        $this->assertNotNull($createdNewsInteraction['id'], 'Created NewsInteraction must have id specified');
        $this->assertNotNull(NewsInteraction::find($createdNewsInteraction['id']), 'NewsInteraction with given id must be in DB');
        $this->assertModelData($newsInteraction, $createdNewsInteraction);
    }

    /**
     * @test read
     */
    public function testReadNewsInteraction()
    {
        $newsInteraction = $this->makeNewsInteraction();
        $dbNewsInteraction = $this->newsInteractionRepo->find($newsInteraction->id);
        $dbNewsInteraction = $dbNewsInteraction->toArray();
        $this->assertModelData($newsInteraction->toArray(), $dbNewsInteraction);
    }

    /**
     * @test update
     */
    public function testUpdateNewsInteraction()
    {
        $newsInteraction = $this->makeNewsInteraction();
        $fakeNewsInteraction = $this->fakeNewsInteractionData();
        $updatedNewsInteraction = $this->newsInteractionRepo->update($fakeNewsInteraction, $newsInteraction->id);
        $this->assertModelData($fakeNewsInteraction, $updatedNewsInteraction->toArray());
        $dbNewsInteraction = $this->newsInteractionRepo->find($newsInteraction->id);
        $this->assertModelData($fakeNewsInteraction, $dbNewsInteraction->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteNewsInteraction()
    {
        $newsInteraction = $this->makeNewsInteraction();
        $resp = $this->newsInteractionRepo->delete($newsInteraction->id);
        $this->assertTrue($resp);
        $this->assertNull(NewsInteraction::find($newsInteraction->id), 'NewsInteraction should not exist in DB');
    }
}
