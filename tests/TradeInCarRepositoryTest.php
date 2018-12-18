<?php

use App\Models\TradeInCar;
use App\Repositories\Admin\TradeInCarRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TradeInCarRepositoryTest extends TestCase
{
    use MakeTradeInCarTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TradeInCarRepository
     */
    protected $tradeInCarRepo;

    public function setUp()
    {
        parent::setUp();
        $this->tradeInCarRepo = App::make(TradeInCarRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTradeInCar()
    {
        $tradeInCar = $this->fakeTradeInCarData();
        $createdTradeInCar = $this->tradeInCarRepo->create($tradeInCar);
        $createdTradeInCar = $createdTradeInCar->toArray();
        $this->assertArrayHasKey('id', $createdTradeInCar);
        $this->assertNotNull($createdTradeInCar['id'], 'Created TradeInCar must have id specified');
        $this->assertNotNull(TradeInCar::find($createdTradeInCar['id']), 'TradeInCar with given id must be in DB');
        $this->assertModelData($tradeInCar, $createdTradeInCar);
    }

    /**
     * @test read
     */
    public function testReadTradeInCar()
    {
        $tradeInCar = $this->makeTradeInCar();
        $dbTradeInCar = $this->tradeInCarRepo->find($tradeInCar->id);
        $dbTradeInCar = $dbTradeInCar->toArray();
        $this->assertModelData($tradeInCar->toArray(), $dbTradeInCar);
    }

    /**
     * @test update
     */
    public function testUpdateTradeInCar()
    {
        $tradeInCar = $this->makeTradeInCar();
        $fakeTradeInCar = $this->fakeTradeInCarData();
        $updatedTradeInCar = $this->tradeInCarRepo->update($fakeTradeInCar, $tradeInCar->id);
        $this->assertModelData($fakeTradeInCar, $updatedTradeInCar->toArray());
        $dbTradeInCar = $this->tradeInCarRepo->find($tradeInCar->id);
        $this->assertModelData($fakeTradeInCar, $dbTradeInCar->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTradeInCar()
    {
        $tradeInCar = $this->makeTradeInCar();
        $resp = $this->tradeInCarRepo->delete($tradeInCar->id);
        $this->assertTrue($resp);
        $this->assertNull(TradeInCar::find($tradeInCar->id), 'TradeInCar should not exist in DB');
    }
}
