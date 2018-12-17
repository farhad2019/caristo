<?php

use Faker\Factory as Faker;
use App\Models\Car;
use App\Repositories\Admin\CarRepository;

trait MakeCarTrait
{
    /**
     * Create fake instance of Car and save it in database
     *
     * @param array $carFields
     * @return Car
     */
    public function makeCar($carFields = [])
    {
        /** @var CarRepository $carRepo */
        $carRepo = App::make(CarRepository::class);
        $theme = $this->fakeCarData($carFields);
        return $carRepo->create($theme);
    }

    /**
     * Get fake instance of Car
     *
     * @param array $carFields
     * @return Car
     */
    public function fakeCar($carFields = [])
    {
        return new Car($this->fakeCarData($carFields));
    }

    /**
     * Get fake data of Car
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarData($carFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'type_id' => $fake->word,
            'category_id' => $fake->word,
            'model_id' => $fake->word,
            'engine_type_id' => $fake->word,
            'regional_specification_id' => $fake->word,
            'owner_id' => $fake->word,
            'year' => $fake->word,
            'chassis' => $fake->word,
            'transmission_type' => $fake->word,
            'kilometre' => $fake->randomDigitNotNull,
            'average_mkp' => $fake->randomDigitNotNull,
            'amount' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'email' => $fake->word,
            'country_code' => $fake->word,
            'phone' => $fake->word,
            'owner_type' => $fake->word,
            'notes' => $fake->text,
            'bid_close_at' => $fake->date('Y-m-d H:i:s'),
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carFields);
    }
}
