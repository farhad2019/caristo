<?php

use App\Models\BidsHistory;
use App\Repositories\Admin\BidsHistoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BidsHistoryRepositoryTest extends TestCase
{
    use MakeBidsHistoryTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var BidsHistoryRepository
     */
    protected $bidsHistoryRepo;

    public function setUp()
    {
        parent::setUp();
        $this->bidsHistoryRepo = App::make(BidsHistoryRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateBidsHistory()
    {
        $bidsHistory = $this->fakeBidsHistoryData();
        $createdBidsHistory = $this->bidsHistoryRepo->create($bidsHistory);
        $createdBidsHistory = $createdBidsHistory->toArray();
        $this->assertArrayHasKey('id', $createdBidsHistory);
        $this->assertNotNull($createdBidsHistory['id'], 'Created BidsHistory must have id specified');
        $this->assertNotNull(BidsHistory::find($createdBidsHistory['id']), 'BidsHistory with given id must be in DB');
        $this->assertModelData($bidsHistory, $createdBidsHistory);
    }

    /**
     * @test read
     */
    public function testReadBidsHistory()
    {
        $bidsHistory = $this->makeBidsHistory();
        $dbBidsHistory = $this->bidsHistoryRepo->find($bidsHistory->id);
        $dbBidsHistory = $dbBidsHistory->toArray();
        $this->assertModelData($bidsHistory->toArray(), $dbBidsHistory);
    }

    /**
     * @test update
     */
    public function testUpdateBidsHistory()
    {
        $bidsHistory = $this->makeBidsHistory();
        $fakeBidsHistory = $this->fakeBidsHistoryData();
        $updatedBidsHistory = $this->bidsHistoryRepo->update($fakeBidsHistory, $bidsHistory->id);
        $this->assertModelData($fakeBidsHistory, $updatedBidsHistory->toArray());
        $dbBidsHistory = $this->bidsHistoryRepo->find($bidsHistory->id);
        $this->assertModelData($fakeBidsHistory, $dbBidsHistory->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteBidsHistory()
    {
        $bidsHistory = $this->makeBidsHistory();
        $resp = $this->bidsHistoryRepo->delete($bidsHistory->id);
        $this->assertTrue($resp);
        $this->assertNull(BidsHistory::find($bidsHistory->id), 'BidsHistory should not exist in DB');
    }
}
