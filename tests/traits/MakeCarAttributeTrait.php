<?php

use Faker\Factory as Faker;
use App\Models\CarAttribute;
use App\Repositories\Admin\CarAttributeRepository;

trait MakeCarAttributeTrait
{
    /**
     * Create fake instance of CarAttribute and save it in database
     *
     * @param array $carAttributeFields
     * @return CarAttribute
     */
    public function makeCarAttribute($carAttributeFields = [])
    {
        /** @var CarAttributeRepository $carAttributeRepo */
        $carAttributeRepo = App::make(CarAttributeRepository::class);
        $theme = $this->fakeCarAttributeData($carAttributeFields);
        return $carAttributeRepo->create($theme);
    }

    /**
     * Get fake instance of CarAttribute
     *
     * @param array $carAttributeFields
     * @return CarAttribute
     */
    public function fakeCarAttribute($carAttributeFields = [])
    {
        return new CarAttribute($this->fakeCarAttributeData($carAttributeFields));
    }

    /**
     * Get fake data of CarAttribute
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarAttributeData($carAttributeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'type' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carAttributeFields);
    }
}
