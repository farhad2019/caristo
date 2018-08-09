<?php

use App\Models\AdsadAsdadjkhasj;
use App\Repositories\Admin\AdsadAsdadjkhasjRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdsadAsdadjkhasjRepositoryTest extends TestCase
{
    use MakeAdsadAsdadjkhasjTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var AdsadAsdadjkhasjRepository
     */
    protected $adsadAsdadjkhasjRepo;

    public function setUp()
    {
        parent::setUp();
        $this->adsadAsdadjkhasjRepo = App::make(AdsadAsdadjkhasjRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->fakeAdsadAsdadjkhasjData();
        $createdAdsadAsdadjkhasj = $this->adsadAsdadjkhasjRepo->create($adsadAsdadjkhasj);
        $createdAdsadAsdadjkhasj = $createdAdsadAsdadjkhasj->toArray();
        $this->assertArrayHasKey('id', $createdAdsadAsdadjkhasj);
        $this->assertNotNull($createdAdsadAsdadjkhasj['id'], 'Created AdsadAsdadjkhasj must have id specified');
        $this->assertNotNull(AdsadAsdadjkhasj::find($createdAdsadAsdadjkhasj['id']), 'AdsadAsdadjkhasj with given id must be in DB');
        $this->assertModelData($adsadAsdadjkhasj, $createdAdsadAsdadjkhasj);
    }

    /**
     * @test read
     */
    public function testReadAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->makeAdsadAsdadjkhasj();
        $dbAdsadAsdadjkhasj = $this->adsadAsdadjkhasjRepo->find($adsadAsdadjkhasj->id);
        $dbAdsadAsdadjkhasj = $dbAdsadAsdadjkhasj->toArray();
        $this->assertModelData($adsadAsdadjkhasj->toArray(), $dbAdsadAsdadjkhasj);
    }

    /**
     * @test update
     */
    public function testUpdateAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->makeAdsadAsdadjkhasj();
        $fakeAdsadAsdadjkhasj = $this->fakeAdsadAsdadjkhasjData();
        $updatedAdsadAsdadjkhasj = $this->adsadAsdadjkhasjRepo->update($fakeAdsadAsdadjkhasj, $adsadAsdadjkhasj->id);
        $this->assertModelData($fakeAdsadAsdadjkhasj, $updatedAdsadAsdadjkhasj->toArray());
        $dbAdsadAsdadjkhasj = $this->adsadAsdadjkhasjRepo->find($adsadAsdadjkhasj->id);
        $this->assertModelData($fakeAdsadAsdadjkhasj, $dbAdsadAsdadjkhasj->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteAdsadAsdadjkhasj()
    {
        $adsadAsdadjkhasj = $this->makeAdsadAsdadjkhasj();
        $resp = $this->adsadAsdadjkhasjRepo->delete($adsadAsdadjkhasj->id);
        $this->assertTrue($resp);
        $this->assertNull(AdsadAsdadjkhasj::find($adsadAsdadjkhasj->id), 'AdsadAsdadjkhasj should not exist in DB');
    }
}
