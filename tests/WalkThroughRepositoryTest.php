<?php

use App\Models\WalkThrough;
use App\Repositories\Admin\WalkThroughRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WalkThroughRepositoryTest extends TestCase
{
    use MakeWalkThroughTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var WalkThroughRepository
     */
    protected $walkThroughRepo;

    public function setUp()
    {
        parent::setUp();
        $this->walkThroughRepo = App::make(WalkThroughRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateWalkThrough()
    {
        $walkThrough = $this->fakeWalkThroughData();
        $createdWalkThrough = $this->walkThroughRepo->create($walkThrough);
        $createdWalkThrough = $createdWalkThrough->toArray();
        $this->assertArrayHasKey('id', $createdWalkThrough);
        $this->assertNotNull($createdWalkThrough['id'], 'Created WalkThrough must have id specified');
        $this->assertNotNull(WalkThrough::find($createdWalkThrough['id']), 'WalkThrough with given id must be in DB');
        $this->assertModelData($walkThrough, $createdWalkThrough);
    }

    /**
     * @test read
     */
    public function testReadWalkThrough()
    {
        $walkThrough = $this->makeWalkThrough();
        $dbWalkThrough = $this->walkThroughRepo->find($walkThrough->id);
        $dbWalkThrough = $dbWalkThrough->toArray();
        $this->assertModelData($walkThrough->toArray(), $dbWalkThrough);
    }

    /**
     * @test update
     */
    public function testUpdateWalkThrough()
    {
        $walkThrough = $this->makeWalkThrough();
        $fakeWalkThrough = $this->fakeWalkThroughData();
        $updatedWalkThrough = $this->walkThroughRepo->update($fakeWalkThrough, $walkThrough->id);
        $this->assertModelData($fakeWalkThrough, $updatedWalkThrough->toArray());
        $dbWalkThrough = $this->walkThroughRepo->find($walkThrough->id);
        $this->assertModelData($fakeWalkThrough, $dbWalkThrough->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteWalkThrough()
    {
        $walkThrough = $this->makeWalkThrough();
        $resp = $this->walkThroughRepo->delete($walkThrough->id);
        $this->assertTrue($resp);
        $this->assertNull(WalkThrough::find($walkThrough->id), 'WalkThrough should not exist in DB');
    }
}
