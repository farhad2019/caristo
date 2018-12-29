<?php

use App\Models\BanksRate;
use App\Repositories\Admin\BanksRateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BanksRateRepositoryTest extends TestCase
{
    use MakeBanksRateTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var BanksRateRepository
     */
    protected $banksRateRepo;

    public function setUp()
    {
        parent::setUp();
        $this->banksRateRepo = App::make(BanksRateRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateBanksRate()
    {
        $banksRate = $this->fakeBanksRateData();
        $createdBanksRate = $this->banksRateRepo->create($banksRate);
        $createdBanksRate = $createdBanksRate->toArray();
        $this->assertArrayHasKey('id', $createdBanksRate);
        $this->assertNotNull($createdBanksRate['id'], 'Created BanksRate must have id specified');
        $this->assertNotNull(BanksRate::find($createdBanksRate['id']), 'BanksRate with given id must be in DB');
        $this->assertModelData($banksRate, $createdBanksRate);
    }

    /**
     * @test read
     */
    public function testReadBanksRate()
    {
        $banksRate = $this->makeBanksRate();
        $dbBanksRate = $this->banksRateRepo->find($banksRate->id);
        $dbBanksRate = $dbBanksRate->toArray();
        $this->assertModelData($banksRate->toArray(), $dbBanksRate);
    }

    /**
     * @test update
     */
    public function testUpdateBanksRate()
    {
        $banksRate = $this->makeBanksRate();
        $fakeBanksRate = $this->fakeBanksRateData();
        $updatedBanksRate = $this->banksRateRepo->update($fakeBanksRate, $banksRate->id);
        $this->assertModelData($fakeBanksRate, $updatedBanksRate->toArray());
        $dbBanksRate = $this->banksRateRepo->find($banksRate->id);
        $this->assertModelData($fakeBanksRate, $dbBanksRate->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteBanksRate()
    {
        $banksRate = $this->makeBanksRate();
        $resp = $this->banksRateRepo->delete($banksRate->id);
        $this->assertTrue($resp);
        $this->assertNull(BanksRate::find($banksRate->id), 'BanksRate should not exist in DB');
    }
}
