<?php

use Faker\Factory as Faker;
use App\Models\MakeBid;
use App\Repositories\Admin\MakeBidRepository;

trait MakeMakeBidTrait
{
    /**
     * Create fake instance of MakeBid and save it in database
     *
     * @param array $makeBidFields
     * @return MakeBid
     */
    public function makeMakeBid($makeBidFields = [])
    {
        /** @var MakeBidRepository $makeBidRepo */
        $makeBidRepo = App::make(MakeBidRepository::class);
        $theme = $this->fakeMakeBidData($makeBidFields);
        return $makeBidRepo->create($theme);
    }

    /**
     * Get fake instance of MakeBid
     *
     * @param array $makeBidFields
     * @return MakeBid
     */
    public function fakeMakeBid($makeBidFields = [])
    {
        return new MakeBid($this->fakeMakeBidData($makeBidFields));
    }

    /**
     * Get fake data of MakeBid
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMakeBidData($makeBidFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'type_id' => $fake->word,
            'model_id' => $fake->word,
            'engine_type_id' => $fake->word,
            'regional_specification_id' => $fake->word,
            'owner_id' => $fake->word,
            'year' => $fake->word,
            'chassis' => $fake->word,
            'transmission_type' => $fake->word,
            'name' => $fake->word,
            'email' => $fake->word,
            'country_code' => $fake->word,
            'phone' => $fake->word,
            'owner_type' => $fake->word,
            'notes' => $fake->text,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $makeBidFields);
    }
}
