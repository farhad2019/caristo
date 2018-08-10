<?php

use Faker\Factory as Faker;
use App\Models\News;
use App\Repositories\Admin\NewsRepository;

trait MakeNewsTrait
{
    /**
     * Create fake instance of News and save it in database
     *
     * @param array $newsFields
     * @return News
     */
    public function makeNews($newsFields = [])
    {
        /** @var NewsRepository $newsRepo */
        $newsRepo = App::make(NewsRepository::class);
        $theme = $this->fakeNewsData($newsFields);
        return $newsRepo->create($theme);
    }

    /**
     * Get fake instance of News
     *
     * @param array $newsFields
     * @return News
     */
    public function fakeNews($newsFields = [])
    {
        return new News($this->fakeNewsData($newsFields));
    }

    /**
     * Get fake data of News
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNewsData($newsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'category_id' => $fake->word,
            'user_id' => $fake->word,
            'views_count' => $fake->word,
            'favorite_count' => $fake->word,
            'like_count' => $fake->word,
            'comments_count' => $fake->word,
            'is_featured' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $newsFields);
    }
}
