<?php

use App\Models\CarsEvaluation;
use App\Repositories\Admin\CarsEvaluationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarsEvaluationRepositoryTest extends TestCase
{
    use MakeCarsEvaluationTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var CarsEvaluationRepository
     */
    protected $carsEvaluationRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carsEvaluationRepo = App::make(CarsEvaluationRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateCarsEvaluation()
    {
        $carsEvaluation = $this->fakeCarsEvaluationData();
        $createdCarsEvaluation = $this->carsEvaluationRepo->create($carsEvaluation);
        $createdCarsEvaluation = $createdCarsEvaluation->toArray();
        $this->assertArrayHasKey('id', $createdCarsEvaluation);
        $this->assertNotNull($createdCarsEvaluation['id'], 'Created CarsEvaluation must have id specified');
        $this->assertNotNull(CarsEvaluation::find($createdCarsEvaluation['id']), 'CarsEvaluation with given id must be in DB');
        $this->assertModelData($carsEvaluation, $createdCarsEvaluation);
    }

    /**
     * @test read
     */
    public function testReadCarsEvaluation()
    {
        $carsEvaluation = $this->makeCarsEvaluation();
        $dbCarsEvaluation = $this->carsEvaluationRepo->find($carsEvaluation->id);
        $dbCarsEvaluation = $dbCarsEvaluation->toArray();
        $this->assertModelData($carsEvaluation->toArray(), $dbCarsEvaluation);
    }

    /**
     * @test update
     */
    public function testUpdateCarsEvaluation()
    {
        $carsEvaluation = $this->makeCarsEvaluation();
        $fakeCarsEvaluation = $this->fakeCarsEvaluationData();
        $updatedCarsEvaluation = $this->carsEvaluationRepo->update($fakeCarsEvaluation, $carsEvaluation->id);
        $this->assertModelData($fakeCarsEvaluation, $updatedCarsEvaluation->toArray());
        $dbCarsEvaluation = $this->carsEvaluationRepo->find($carsEvaluation->id);
        $this->assertModelData($fakeCarsEvaluation, $dbCarsEvaluation->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteCarsEvaluation()
    {
        $carsEvaluation = $this->makeCarsEvaluation();
        $resp = $this->carsEvaluationRepo->delete($carsEvaluation->id);
        $this->assertTrue($resp);
        $this->assertNull(CarsEvaluation::find($carsEvaluation->id), 'CarsEvaluation should not exist in DB');
    }
}
