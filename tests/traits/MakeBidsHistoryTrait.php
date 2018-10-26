<?php

use Faker\Factory as Faker;
use App\Models\BidsHistory;
use App\Repositories\Admin\BidsHistoryRepository;

trait MakeBidsHistoryTrait
{
    /**
     * Create fake instance of BidsHistory and save it in database
     *
     * @param array $bidsHistoryFields
     * @return BidsHistory
     */
    public function makeBidsHistory($bidsHistoryFields = [])
    {
        /** @var BidsHistoryRepository $bidsHistoryRepo */
        $bidsHistoryRepo = App::make(BidsHistoryRepository::class);
        $theme = $this->fakeBidsHistoryData($bidsHistoryFields);
        return $bidsHistoryRepo->create($theme);
    }

    /**
     * Get fake instance of BidsHistory
     *
     * @param array $bidsHistoryFields
     * @return BidsHistory
     */
    public function fakeBidsHistory($bidsHistoryFields = [])
    {
        return new BidsHistory($this->fakeBidsHistoryData($bidsHistoryFields));
    }

    /**
     * Get fake data of BidsHistory
     *
     * @param array $postFields
     * @return array
     */
    public function fakeBidsHistoryData($bidsHistoryFields = [])
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
        ], $bidsHistoryFields);
    }
}
