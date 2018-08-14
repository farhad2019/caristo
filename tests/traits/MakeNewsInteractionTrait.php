<?php

use Faker\Factory as Faker;
use App\Models\NewsInteraction;
use App\Repositories\Admin\NewsInteractionRepository;

trait MakeNewsInteractionTrait
{
    /**
     * Create fake instance of NewsInteraction and save it in database
     *
     * @param array $newsInteractionFields
     * @return NewsInteraction
     */
    public function makeNewsInteraction($newsInteractionFields = [])
    {
        /** @var NewsInteractionRepository $newsInteractionRepo */
        $newsInteractionRepo = App::make(NewsInteractionRepository::class);
        $theme = $this->fakeNewsInteractionData($newsInteractionFields);
        return $newsInteractionRepo->create($theme);
    }

    /**
     * Get fake instance of NewsInteraction
     *
     * @param array $newsInteractionFields
     * @return NewsInteraction
     */
    public function fakeNewsInteraction($newsInteractionFields = [])
    {
        return new NewsInteraction($this->fakeNewsInteractionData($newsInteractionFields));
    }

    /**
     * Get fake data of NewsInteraction
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNewsInteractionData($newsInteractionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->word,
            'news_id' => $fake->word,
            'type' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $newsInteractionFields);
    }
}
