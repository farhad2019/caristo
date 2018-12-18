<?php

use Faker\Factory as Faker;
use App\Models\TradeInCar;
use App\Repositories\Admin\TradeInCarRepository;

trait MakeTradeInCarTrait
{
    /**
     * Create fake instance of TradeInCar and save it in database
     *
     * @param array $tradeInCarFields
     * @return TradeInCar
     */
    public function makeTradeInCar($tradeInCarFields = [])
    {
        /** @var TradeInCarRepository $tradeInCarRepo */
        $tradeInCarRepo = App::make(TradeInCarRepository::class);
        $theme = $this->fakeTradeInCarData($tradeInCarFields);
        return $tradeInCarRepo->create($theme);
    }

    /**
     * Get fake instance of TradeInCar
     *
     * @param array $tradeInCarFields
     * @return TradeInCar
     */
    public function fakeTradeInCar($tradeInCarFields = [])
    {
        return new TradeInCar($this->fakeTradeInCarData($tradeInCarFields));
    }

    /**
     * Get fake data of TradeInCar
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTradeInCarData($tradeInCarFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'owner_car_id' => $fake->word,
            'customer_car_id' => $fake->word,
            'user_id' => $fake->word,
            'amount' => $fake->randomDigitNotNull,
            'notes' => $fake->text,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $tradeInCarFields);
    }
}
