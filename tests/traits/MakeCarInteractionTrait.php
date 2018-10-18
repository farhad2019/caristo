<?php

use Faker\Factory as Faker;
use App\Models\CarInteraction;
use App\Repositories\Admin\CarInteractionRepository;

trait MakeCarInteractionTrait
{
    /**
     * Create fake instance of CarInteraction and save it in database
     *
     * @param array $carInteractionFields
     * @return CarInteraction
     */
    public function makeCarInteraction($carInteractionFields = [])
    {
        /** @var CarInteractionRepository $carInteractionRepo */
        $carInteractionRepo = App::make(CarInteractionRepository::class);
        $theme = $this->fakeCarInteractionData($carInteractionFields);
        return $carInteractionRepo->create($theme);
    }

    /**
     * Get fake instance of CarInteraction
     *
     * @param array $carInteractionFields
     * @return CarInteraction
     */
    public function fakeCarInteraction($carInteractionFields = [])
    {
        return new CarInteraction($this->fakeCarInteractionData($carInteractionFields));
    }

    /**
     * Get fake data of CarInteraction
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCarInteractionData($carInteractionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->word,
            'car_id' => $fake->word,
            'type' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $carInteractionFields);
    }
}
