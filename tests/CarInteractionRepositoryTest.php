<?php

use App\Models\CarInteraction;
use App\Repositories\Admin\CarInteractionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarInteractionRepositoryTest extends TestCase
{
    use MakeCarInteractionTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarInteractionRepository
     */
    protected $carInteractionRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carInteractionRepo = App::make(CarInteractionRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarInteraction()
    {
        $carInteraction = $this->fakeCarInteractionData();
        $createdCarInteraction = $this->carInteractionRepo->create($carInteraction);
        $createdCarInteraction = $createdCarInteraction->toArray();
        $this->assertArrayHasKey('id', $createdCarInteraction);
        $this->assertNotNull($createdCarInteraction['id'], 'Created CarInteraction must have id specified');
        $this->assertNotNull(CarInteraction::find($createdCarInteraction['id']), 'CarInteraction with given id must be in DB');
        $this->assertModelData($carInteraction, $createdCarInteraction);
    }

    /**
     * @test read
     */
    public function testReadCarInteraction()
    {
        $carInteraction = $this->makeCarInteraction();
        $dbCarInteraction = $this->carInteractionRepo->find($carInteraction->id);
        $dbCarInteraction = $dbCarInteraction->toArray();
        $this->assertModelData($carInteraction->toArray(), $dbCarInteraction);
    }

    /**
     * @test update
     */
    public function testUpdateCarInteraction()
    {
        $carInteraction = $this->makeCarInteraction();
        $fakeCarInteraction = $this->fakeCarInteractionData();
        $updatedCarInteraction = $this->carInteractionRepo->update($fakeCarInteraction, $carInteraction->id);
        $this->assertModelData($fakeCarInteraction, $updatedCarInteraction->toArray());
        $dbCarInteraction = $this->carInteractionRepo->find($carInteraction->id);
        $this->assertModelData($fakeCarInteraction, $dbCarInteraction->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarInteraction()
    {
        $carInteraction = $this->makeCarInteraction();
        $resp = $this->carInteractionRepo->delete($carInteraction->id);
        $this->assertTrue($resp);
        $this->assertNull(CarInteraction::find($carInteraction->id), 'CarInteraction should not exist in DB');
    }
}
