<?php

use Faker\Factory as Faker;
use App\Models\AsdasdAsdSad;
use App\Repositories\Admin\AsdasdAsdSadRepository;

trait MakeAsdasdAsdSadTrait
{
    /**
     * Create fake instance of AsdasdAsdSad and save it in database
     *
     * @param array $asdasdAsdSadFields
     * @return AsdasdAsdSad
     */
    public function makeAsdasdAsdSad($asdasdAsdSadFields = [])
    {
        /** @var AsdasdAsdSadRepository $asdasdAsdSadRepo */
        $asdasdAsdSadRepo = App::make(AsdasdAsdSadRepository::class);
        $theme = $this->fakeAsdasdAsdSadData($asdasdAsdSadFields);
        return $asdasdAsdSadRepo->create($theme);
    }

    /**
     * Get fake instance of AsdasdAsdSad
     *
     * @param array $asdasdAsdSadFields
     * @return AsdasdAsdSad
     */
    public function fakeAsdasdAsdSad($asdasdAsdSadFields = [])
    {
        return new AsdasdAsdSad($this->fakeAsdasdAsdSadData($asdasdAsdSadFields));
    }

    /**
     * Get fake data of AsdasdAsdSad
     *
     * @param array $postFields
     * @return array
     */
    public function fakeAsdasdAsdSadData($asdasdAsdSadFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'email' => $fake->word,
            'password' => $fake->word,
            'remember_token' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $asdasdAsdSadFields);
    }
}
