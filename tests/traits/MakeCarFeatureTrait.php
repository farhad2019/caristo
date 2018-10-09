<?php

use Faker\Factory as Faker;
use App\Models\CarFeature;
use App\Repositories\Admin\CarFeatureRepository;

trait MakeCarFeatureTrait
{
    /**
     * Create fake instance of CarFeature and save it in database
     *
     * @param array $carFeatureFields
     * @return CarFeature
     */
    public function makeCarFeature($carFeatureFields = [])
    {
        /** @var CarFeatureRepository $carFeatureRepo */
        $carFeatureRepo = App::make(CarFeatureRepository::class);
        $theme = $this->fakeCarFeatureData($carFeatureFields);
        return $carFeatureRepo->create($theme);
    }

    /**
     * Get fake instance of CarFeature
     *
     * @param array $carFeatureFields
     * @return CarFeature
     */
    public function fakeCarFeature($carFeatureFields = [])
    {
        return new CarFeature($this->fakeCarFeatureData($carFeatureFields));
    }

    /**
     * Get fake data of CarFeature
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarFeatureData($carFeatureFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carFeatureFields);
    }
}
