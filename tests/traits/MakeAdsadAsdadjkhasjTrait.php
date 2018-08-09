<?php

use Faker\Factory as Faker;
use App\Models\AdsadAsdadjkhasj;
use App\Repositories\Admin\AdsadAsdadjkhasjRepository;

trait MakeAdsadAsdadjkhasjTrait
{
    /**
     * Create fake instance of AdsadAsdadjkhasj and save it in database
     *
     * @param array $adsadAsdadjkhasjFields
     * @return AdsadAsdadjkhasj
     */
    public function makeAdsadAsdadjkhasj($adsadAsdadjkhasjFields = [])
    {
        /** @var AdsadAsdadjkhasjRepository $adsadAsdadjkhasjRepo */
        $adsadAsdadjkhasjRepo = App::make(AdsadAsdadjkhasjRepository::class);
        $theme = $this->fakeAdsadAsdadjkhasjData($adsadAsdadjkhasjFields);
        return $adsadAsdadjkhasjRepo->create($theme);
    }

    /**
     * Get fake instance of AdsadAsdadjkhasj
     *
     * @param array $adsadAsdadjkhasjFields
     * @return AdsadAsdadjkhasj
     */
    public function fakeAdsadAsdadjkhasj($adsadAsdadjkhasjFields = [])
    {
        return new AdsadAsdadjkhasj($this->fakeAdsadAsdadjkhasjData($adsadAsdadjkhasjFields));
    }

    /**
     * Get fake data of AdsadAsdadjkhasj
     *
     * @param array $postFields
     * @return array
     */
    public function fakeAdsadAsdadjkhasjData($adsadAsdadjkhasjFields = [])
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
        ], $adsadAsdadjkhasjFields);
    }
}
