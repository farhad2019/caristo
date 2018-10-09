<?php

use Faker\Factory as Faker;
use App\Models\MyCar;
use App\Repositories\Admin\MyCarRepository;

trait MakeMyCarTrait
{
    /**
     * Create fake instance of MyCar and save it in database
     *
     * @param array $myCarFields
     * @return MyCar
     */
    public function makeMyCar($myCarFields = [])
    {
        /** @var MyCarRepository $myCarRepo */
        $myCarRepo = App::make(MyCarRepository::class);
        $theme = $this->fakeMyCarData($myCarFields);
        return $myCarRepo->create($theme);
    }

    /**
     * Get fake instance of MyCar
     *
     * @param array $myCarFields
     * @return MyCar
     */
    public function fakeMyCar($myCarFields = [])
    {
        return new MyCar($this->fakeMyCarData($myCarFields));
    }

    /**
     * Get fake data of MyCar
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMyCarData($myCarFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'type_id' => $fake->word,
            'model_id' => $fake->word,
            'engine_type_id' => $fake->word,
            'owner_id' => $fake->word,
            'year' => $fake->word,
            'transmission_type' => $fake->word,
            'name' => $fake->word,
            'email' => $fake->word,
            'country_code' => $fake->word,
            'phone' => $fake->word,
            'owner_type' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $myCarFields);
    }
}
