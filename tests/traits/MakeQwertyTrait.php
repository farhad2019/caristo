<?php

use Faker\Factory as Faker;
use App\Models\Qwerty;
use App\Repositories\Admin\QwertyRepository;

trait MakeQwertyTrait
{
    /**
     * Create fake instance of Qwerty and save it in database
     *
     * @param array $qwertyFields
     * @return Qwerty
     */
    public function makeQwerty($qwertyFields = [])
    {
        /** @var QwertyRepository $qwertyRepo */
        $qwertyRepo = App::make(QwertyRepository::class);
        $theme = $this->fakeQwertyData($qwertyFields);
        return $qwertyRepo->create($theme);
    }

    /**
     * Get fake instance of Qwerty
     *
     * @param array $qwertyFields
     * @return Qwerty
     */
    public function fakeQwerty($qwertyFields = [])
    {
        return new Qwerty($this->fakeQwertyData($qwertyFields));
    }

    /**
     * Get fake data of Qwerty
     *
     * @param array $postFields
     * @return array
     */
    public function fakeQwertyData($qwertyFields = [])
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
        ], $qwertyFields);
    }
}
