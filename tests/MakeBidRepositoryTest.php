<?php

use App\Models\MakeBid;
use App\Repositories\Admin\MakeBidRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MakeBidRepositoryTest extends TestCase
{
    use MakeMakeBidTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MakeBidRepository
     */
    protected $makeBidRepo;

    public function setUp()
    {
        parent::setUp();
        $this->makeBidRepo = App::make(MakeBidRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMakeBid()
    {
        $makeBid = $this->fakeMakeBidData();
        $createdMakeBid = $this->makeBidRepo->create($makeBid);
        $createdMakeBid = $createdMakeBid->toArray();
        $this->assertArrayHasKey('id', $createdMakeBid);
        $this->assertNotNull($createdMakeBid['id'], 'Created MakeBid must have id specified');
        $this->assertNotNull(MakeBid::find($createdMakeBid['id']), 'MakeBid with given id must be in DB');
        $this->assertModelData($makeBid, $createdMakeBid);
    }

    /**
     * @test read
     */
    public function testReadMakeBid()
    {
        $makeBid = $this->makeMakeBid();
        $dbMakeBid = $this->makeBidRepo->find($makeBid->id);
        $dbMakeBid = $dbMakeBid->toArray();
        $this->assertModelData($makeBid->toArray(), $dbMakeBid);
    }

    /**
     * @test update
     */
    public function testUpdateMakeBid()
    {
        $makeBid = $this->makeMakeBid();
        $fakeMakeBid = $this->fakeMakeBidData();
        $updatedMakeBid = $this->makeBidRepo->update($fakeMakeBid, $makeBid->id);
        $this->assertModelData($fakeMakeBid, $updatedMakeBid->toArray());
        $dbMakeBid = $this->makeBidRepo->find($makeBid->id);
        $this->assertModelData($fakeMakeBid, $dbMakeBid->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMakeBid()
    {
        $makeBid = $this->makeMakeBid();
        $resp = $this->makeBidRepo->delete($makeBid->id);
        $this->assertTrue($resp);
        $this->assertNull(MakeBid::find($makeBid->id), 'MakeBid should not exist in DB');
    }
}
