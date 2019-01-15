<?php

use Faker\Factory as Faker;
use App\Models\CarsEvaluation;
use App\Repositories\Admin\CarsEvaluationRepository;

trait MakeCarsEvaluationTrait
{
    /**
     * Create fake instance of CarsEvaluation and save it in database
     *
     * @param array $carsEvaluationFields
     * @return CarsEvaluation
     */
    public function makeCarsEvaluation($carsEvaluationFields = [])
    {
        /** @var CarsEvaluationRepository $carsEvaluationRepo */
        $carsEvaluationRepo = App::make(CarsEvaluationRepository::class);
        $theme = $this->fakeCarsEvaluationData($carsEvaluationFields);
        return $carsEvaluationRepo->create($theme);
    }

    /**
     * Get fake instance of CarsEvaluation
     *
     * @param array $carsEvaluationFields
     * @return CarsEvaluation
     */
    public function fakeCarsEvaluation($carsEvaluationFields = [])
    {
        return new CarsEvaluation($this->fakeCarsEvaluationData($carsEvaluationFields));
    }

    /**
     * Get fake data of CarsEvaluation
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarsEvaluationData($carsEvaluationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'car_id' => $fake->word,
            'user_id' => $fake->word,
            'amount' => $fake->randomDigitNotNull,
            'status' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carsEvaluationFields);
    }
}
