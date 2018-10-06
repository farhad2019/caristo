<?php

use Faker\Factory as Faker;
use App\Models\CarBrand;
use App\Repositories\Admin\CarBrandRepository;

trait MakeCarBrandTrait
{
    /**
     * Create fake instance of CarBrand and save it in database
     *
     * @param array $carBrandFields
     * @return CarBrand
     */
    public function makeCarBrand($carBrandFields = [])
    {
        /** @var CarBrandRepository $carBrandRepo */
        $carBrandRepo = App::make(CarBrandRepository::class);
        $theme = $this->fakeCarBrandData($carBrandFields);
        return $carBrandRepo->create($theme);
    }

    /**
     * Get fake instance of CarBrand
     *
     * @param array $carBrandFields
     * @return CarBrand
     */
    public function fakeCarBrand($carBrandFields = [])
    {
        return new CarBrand($this->fakeCarBrandData($carBrandFields));
    }

    /**
     * Get fake data of CarBrand
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarBrandData($carBrandFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carBrandFields);
    }
}
