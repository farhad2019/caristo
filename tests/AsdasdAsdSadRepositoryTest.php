<?php

use App\Models\AsdasdAsdSad;
use App\Repositories\Admin\AsdasdAsdSadRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AsdasdAsdSadRepositoryTest extends TestCase
{
    use MakeAsdasdAsdSadTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var AsdasdAsdSadRepository
     */
    protected $asdasdAsdSadRepo;

    public function setUp()
    {
        parent::setUp();
        $this->asdasdAsdSadRepo = App::make(AsdasdAsdSadRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->fakeAsdasdAsdSadData();
        $createdAsdasdAsdSad = $this->asdasdAsdSadRepo->create($asdasdAsdSad);
        $createdAsdasdAsdSad = $createdAsdasdAsdSad->toArray();
        $this->assertArrayHasKey('id', $createdAsdasdAsdSad);
        $this->assertNotNull($createdAsdasdAsdSad['id'], 'Created AsdasdAsdSad must have id specified');
        $this->assertNotNull(AsdasdAsdSad::find($createdAsdasdAsdSad['id']), 'AsdasdAsdSad with given id must be in DB');
        $this->assertModelData($asdasdAsdSad, $createdAsdasdAsdSad);
    }

    /**
     * @test read
     */
    public function testReadAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->makeAsdasdAsdSad();
        $dbAsdasdAsdSad = $this->asdasdAsdSadRepo->find($asdasdAsdSad->id);
        $dbAsdasdAsdSad = $dbAsdasdAsdSad->toArray();
        $this->assertModelData($asdasdAsdSad->toArray(), $dbAsdasdAsdSad);
    }

    /**
     * @test update
     */
    public function testUpdateAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->makeAsdasdAsdSad();
        $fakeAsdasdAsdSad = $this->fakeAsdasdAsdSadData();
        $updatedAsdasdAsdSad = $this->asdasdAsdSadRepo->update($fakeAsdasdAsdSad, $asdasdAsdSad->id);
        $this->assertModelData($fakeAsdasdAsdSad, $updatedAsdasdAsdSad->toArray());
        $dbAsdasdAsdSad = $this->asdasdAsdSadRepo->find($asdasdAsdSad->id);
        $this->assertModelData($fakeAsdasdAsdSad, $dbAsdasdAsdSad->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteAsdasdAsdSad()
    {
        $asdasdAsdSad = $this->makeAsdasdAsdSad();
        $resp = $this->asdasdAsdSadRepo->delete($asdasdAsdSad->id);
        $this->assertTrue($resp);
        $this->assertNull(AsdasdAsdSad::find($asdasdAsdSad->id), 'AsdasdAsdSad should not exist in DB');
    }
}
