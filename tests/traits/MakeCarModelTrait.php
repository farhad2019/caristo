<?php

use Faker\Factory as Faker;
use App\Models\CarModel;
use App\Repositories\Admin\CarModelRepository;

trait MakeCarModelTrait
{
    /**
     * Create fake instance of CarModel and save it in database
     *
     * @param array $carModelFields
     * @return CarModel
     */
    public function makeCarModel($carModelFields = [])
    {
        /** @var CarModelRepository $carModelRepo */
        $carModelRepo = App::make(CarModelRepository::class);
        $theme = $this->fakeCarModelData($carModelFields);
        return $carModelRepo->create($theme);
    }

    /**
     * Get fake instance of CarModel
     *
     * @param array $carModelFields
     * @return CarModel
     */
    public function fakeCarModel($carModelFields = [])
    {
        return new CarModel($this->fakeCarModelData($carModelFields));
    }

    /**
     * Get fake data of CarModel
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarModelData($carModelFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'brand_id' => $fake->word,
            'year' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carModelFields);
    }
}
