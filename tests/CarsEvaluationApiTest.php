<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarsEvaluationApiTest extends TestCase
{
    use MakeCarsEvaluationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateCarsEvaluation()
    {
        $carsEvaluation = $this->fakeCarsEvaluationData();
        $this->json('POST', '/api/v1/carsEvaluations', $carsEvaluation);

        $this->assertApiResponse($carsEvaluation);
    }

    /**
     * @test
     */
    public function testReadCarsEvaluation()
    {
        $carsEvaluation = $this->makeCarsEvaluation();
        $this->json('GET', '/api/v1/carsEvaluations/'.$carsEvaluation->id);

        $this->assertApiResponse($carsEvaluation->toArray());
    }

    /**
     * @test
     */
    public function testUpdateCarsEvaluation()
    {
        $carsEvaluation = $this->makeCarsEvaluation();
        $editedCarsEvaluation = $this->fakeCarsEvaluationData();

        $this->json('PUT', '/api/v1/carsEvaluations/'.$carsEvaluation->id, $editedCarsEvaluation);

        $this->assertApiResponse($editedCarsEvaluation);
    }

    /**
     * @test
     */
    public function testDeleteCarsEvaluation()
    {
        $carsEvaluation = $this->makeCarsEvaluation();
        $this->json('DELETE', '/api/v1/carsEvaluations/'.$carsEvaluation->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carsEvaluations/'.$carsEvaluation->id);

        $this->assertResponseStatus(404);
    }
}
