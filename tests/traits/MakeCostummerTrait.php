<?php

use Faker\Factory as Faker;
use App\Models\Costummer;
use App\Repositories\Admin\CostummerRepository;

trait MakeCostummerTrait
{
    /**
     * Create fake instance of Costummer and save it in database
     *
     * @param array $costummerFields
     * @return Costummer
     */
    public function makeCostummer($costummerFields = [])
    {
        /** @var CostummerRepository $costummerRepo */
        $costummerRepo = App::make(CostummerRepository::class);
        $theme = $this->fakeCostummerData($costummerFields);
        return $costummerRepo->create($theme);
    }

    /**
     * Get fake instance of Costummer
     *
     * @param array $costummerFields
     * @return Costummer
     */
    public function fakeCostummer($costummerFields = [])
    {
        return new Costummer($this->fakeCostummerData($costummerFields));
    }

    /**
     * Get fake data of Costummer
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCostummerData($costummerFields = [])
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
        ], $costummerFields);
    }
}
