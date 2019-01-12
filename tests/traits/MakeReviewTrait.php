<?php

use Faker\Factory as Faker;
use App\Models\Review;
use App\Repositories\Admin\ReviewRepository;

trait MakeReviewTrait
{
    /**
     * Create fake instance of Review and save it in database
     *
     * @param array $reviewFields
     * @return Review
     */
    public function makeReview($reviewFields = [])
    {
        /** @var ReviewRepository $reviewRepo */
        $reviewRepo = App::make(ReviewRepository::class);
        $theme = $this->fakeReviewData($reviewFields);
        return $reviewRepo->create($theme);
    }

    /**
     * Get fake instance of Review
     *
     * @param array $reviewFields
     * @return Review
     */
    public function fakeReview($reviewFields = [])
    {
        return new Review($this->fakeReviewData($reviewFields));
    }

    /**
     * Get fake data of Review
     *
     * @param array $postFields
     * @return array
     */
    public function fakeReviewData($reviewFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'user_id' => $fake->word,
            'car_id' => $fake->word,
            'average_rating' => $fake->randomDigitNotNull,
            'review_message' => $fake->text,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $reviewFields);
    }
}
