<?php

use Faker\Factory as Faker;
use App\Models\PersonalShopperRequest;
use App\Repositories\Admin\PersonalShopperRequestRepository;

trait MakePersonalShopperRequestTrait
{
    /**
     * Create fake instance of PersonalShopperRequest and save it in database
     *
     * @param array $personalShopperRequestFields
     * @return PersonalShopperRequest
     */
    public function makePersonalShopperRequest($personalShopperRequestFields = [])
    {
        /** @var PersonalShopperRequestRepository $personalShopperRequestRepo */
        $personalShopperRequestRepo = App::make(PersonalShopperRequestRepository::class);
        $theme = $this->fakePersonalShopperRequestData($personalShopperRequestFields);
        return $personalShopperRequestRepo->create($theme);
    }

    /**
     * Get fake instance of PersonalShopperRequest
     *
     * @param array $personalShopperRequestFields
     * @return PersonalShopperRequest
     */
    public function fakePersonalShopperRequest($personalShopperRequestFields = [])
    {
        return new PersonalShopperRequest($this->fakePersonalShopperRequestData($personalShopperRequestFields));
    }

    /**
     * Get fake data of PersonalShopperRequest
     *
     * @param array $postFields
     * @return array
     */
    public function fakePersonalShopperRequestData($personalShopperRequestFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->word,
            'car_id' => $fake->word,
            'bank_id' => $fake->word,
            'type' => $fake->word,
            'name' => $fake->word,
            'email' => $fake->word,
            'country_code' => $fake->word,
            'phone' => $fake->word,
            'subject' => $fake->word,
            'message' => $fake->text,
            'status' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $personalShopperRequestFields);
    }
}
