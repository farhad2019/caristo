<?php

use Faker\Factory as Faker;
use App\Models\CarVersion;
use App\Repositories\Admin\CarVersionRepository;

trait MakeCarVersionTrait
{
    /**
     * Create fake instance of CarVersion and save it in database
     *
     * @param array $carVersionFields
     * @return CarVersion
     */
    public function makeCarVersion($carVersionFields = [])
    {
        /** @var CarVersionRepository $carVersionRepo */
        $carVersionRepo = App::make(CarVersionRepository::class);
        $theme = $this->fakeCarVersionData($carVersionFields);
        return $carVersionRepo->create($theme);
    }

    /**
     * Get fake instance of CarVersion
     *
     * @param array $carVersionFields
     * @return CarVersion
     */
    public function fakeCarVersion($carVersionFields = [])
    {
        return new CarVersion($this->fakeCarVersionData($carVersionFields));
    }

    /**
     * Get fake data of CarVersion
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarVersionData($carVersionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'model_id' => $fake->word,
            'title' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carVersionFields);
    }
}
