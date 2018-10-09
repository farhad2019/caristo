<?php

use Faker\Factory as Faker;
use App\Models\CarType;
use App\Repositories\Admin\CarTypeRepository;

trait MakeCarTypeTrait
{
    /**
     * Create fake instance of CarType and save it in database
     *
     * @param array $carTypeFields
     * @return CarType
     */
    public function makeCarType($carTypeFields = [])
    {
        /** @var CarTypeRepository $carTypeRepo */
        $carTypeRepo = App::make(CarTypeRepository::class);
        $theme = $this->fakeCarTypeData($carTypeFields);
        return $carTypeRepo->create($theme);
    }

    /**
     * Get fake instance of CarType
     *
     * @param array $carTypeFields
     * @return CarType
     */
    public function fakeCarType($carTypeFields = [])
    {
        return new CarType($this->fakeCarTypeData($carTypeFields));
    }

    /**
     * Get fake data of CarType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarTypeData($carTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carTypeFields);
    }
}
