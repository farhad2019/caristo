<?php

use Faker\Factory as Faker;
use App\Models\BanksRate;
use App\Repositories\Admin\BanksRateRepository;

trait MakeBanksRateTrait
{
    /**
     * Create fake instance of BanksRate and save it in database
     *
     * @param array $banksRateFields
     * @return BanksRate
     */
    public function makeBanksRate($banksRateFields = [])
    {
        /** @var BanksRateRepository $banksRateRepo */
        $banksRateRepo = App::make(BanksRateRepository::class);
        $theme = $this->fakeBanksRateData($banksRateFields);
        return $banksRateRepo->create($theme);
    }

    /**
     * Get fake instance of BanksRate
     *
     * @param array $banksRateFields
     * @return BanksRate
     */
    public function fakeBanksRate($banksRateFields = [])
    {
        return new BanksRate($this->fakeBanksRateData($banksRateFields));
    }

    /**
     * Get fake data of BanksRate
     *
     * @param array $postFields
     * @return array
     */
    public function fakeBanksRateData($banksRateFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'title' => $fake->word,
            'phone_no' => $fake->word,
            'address' => $fake->text,
            'rate' => $fake->randomDigitNotNull,
            'type' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $banksRateFields);
    }
}
