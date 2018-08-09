<?php

use App\Models\Qwerty;
use App\Repositories\Admin\QwertyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class QwertyRepositoryTest extends TestCase
{
    use MakeQwertyTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var QwertyRepository
     */
    protected $qwertyRepo;

    public function setUp()
    {
        parent::setUp();
        $this->qwertyRepo = App::make(QwertyRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateQwerty()
    {
        $qwerty = $this->fakeQwertyData();
        $createdQwerty = $this->qwertyRepo->create($qwerty);
        $createdQwerty = $createdQwerty->toArray();
        $this->assertArrayHasKey('id', $createdQwerty);
        $this->assertNotNull($createdQwerty['id'], 'Created Qwerty must have id specified');
        $this->assertNotNull(Qwerty::find($createdQwerty['id']), 'Qwerty with given id must be in DB');
        $this->assertModelData($qwerty, $createdQwerty);
    }

    /**
     * @test read
     */
    public function testReadQwerty()
    {
        $qwerty = $this->makeQwerty();
        $dbQwerty = $this->qwertyRepo->find($qwerty->id);
        $dbQwerty = $dbQwerty->toArray();
        $this->assertModelData($qwerty->toArray(), $dbQwerty);
    }

    /**
     * @test update
     */
    public function testUpdateQwerty()
    {
        $qwerty = $this->makeQwerty();
        $fakeQwerty = $this->fakeQwertyData();
        $updatedQwerty = $this->qwertyRepo->update($fakeQwerty, $qwerty->id);
        $this->assertModelData($fakeQwerty, $updatedQwerty->toArray());
        $dbQwerty = $this->qwertyRepo->find($qwerty->id);
        $this->assertModelData($fakeQwerty, $dbQwerty->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteQwerty()
    {
        $qwerty = $this->makeQwerty();
        $resp = $this->qwertyRepo->delete($qwerty->id);
        $this->assertTrue($resp);
        $this->assertNull(Qwerty::find($qwerty->id), 'Qwerty should not exist in DB');
    }
}
