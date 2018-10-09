<?php

use App\Models\MyCar;
use App\Repositories\Admin\MyCarRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MyCarRepositoryTest extends TestCase
{
    use MakeMyCarTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var MyCarRepository
     */
    protected $myCarRepo;

    public function setUp()
    {
        parent::setUp();
        $this->myCarRepo = App::make(MyCarRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateMyCar()
    {
        $myCar = $this->fakeMyCarData();
        $createdMyCar = $this->myCarRepo->create($myCar);
        $createdMyCar = $createdMyCar->toArray();
        $this->assertArrayHasKey('id', $createdMyCar);
        $this->assertNotNull($createdMyCar['id'], 'Created MyCar must have id specified');
        $this->assertNotNull(MyCar::find($createdMyCar['id']), 'MyCar with given id must be in DB');
        $this->assertModelData($myCar, $createdMyCar);
    }

    /**
     * @test read
     */
    public function testReadMyCar()
    {
        $myCar = $this->makeMyCar();
        $dbMyCar = $this->myCarRepo->find($myCar->id);
        $dbMyCar = $dbMyCar->toArray();
        $this->assertModelData($myCar->toArray(), $dbMyCar);
    }

    /**
     * @test update
     */
    public function testUpdateMyCar()
    {
        $myCar = $this->makeMyCar();
        $fakeMyCar = $this->fakeMyCarData();
        $updatedMyCar = $this->myCarRepo->update($fakeMyCar, $myCar->id);
        $this->assertModelData($fakeMyCar, $updatedMyCar->toArray());
        $dbMyCar = $this->myCarRepo->find($myCar->id);
        $this->assertModelData($fakeMyCar, $dbMyCar->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteMyCar()
    {
        $myCar = $this->makeMyCar();
        $resp = $this->myCarRepo->delete($myCar->id);
        $this->assertTrue($resp);
        $this->assertNull(MyCar::find($myCar->id), 'MyCar should not exist in DB');
    }
}
