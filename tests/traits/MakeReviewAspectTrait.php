<?php

use Faker\Factory as Faker;
use App\Models\ReviewAspect;
use App\Repositories\Admin\ReviewAspectRepository;

trait MakeReviewAspectTrait
{
    /**
     * Create fake instance of ReviewAspect and save it in database
     *
     * @param array $reviewAspectFields
     * @return ReviewAspect
     */
    public function makeReviewAspect($reviewAspectFields = [])
    {
        /** @var ReviewAspectRepository $reviewAspectRepo */
        $reviewAspectRepo = App::make(ReviewAspectRepository::class);
        $theme = $this->fakeReviewAspectData($reviewAspectFields);
        return $reviewAspectRepo->create($theme);
    }

    /**
     * Get fake instance of ReviewAspect
     *
     * @param array $reviewAspectFields
     * @return ReviewAspect
     */
    public function fakeReviewAspect($reviewAspectFields = [])
    {
        return new ReviewAspect($this->fakeReviewAspectData($reviewAspectFields));
    }

    /**
     * Get fake data of ReviewAspect
     *
     * @param array $postFields
     * @return array
     */
    public function fakeReviewAspectData($reviewAspectFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $reviewAspectFields);
    }
}
