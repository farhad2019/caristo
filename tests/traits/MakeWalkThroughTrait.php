<?php

use Faker\Factory as Faker;
use App\Models\WalkThrough;
use App\Repositories\Admin\WalkThroughRepository;

trait MakeWalkThroughTrait
{
    /**
     * Create fake instance of WalkThrough and save it in database
     *
     * @param array $walkThroughFields
     * @return WalkThrough
     */
    public function makeWalkThrough($walkThroughFields = [])
    {
        /** @var WalkThroughRepository $walkThroughRepo */
        $walkThroughRepo = App::make(WalkThroughRepository::class);
        $theme = $this->fakeWalkThroughData($walkThroughFields);
        return $walkThroughRepo->create($theme);
    }

    /**
     * Get fake instance of WalkThrough
     *
     * @param array $walkThroughFields
     * @return WalkThrough
     */
    public function fakeWalkThrough($walkThroughFields = [])
    {
        return new WalkThrough($this->fakeWalkThroughData($walkThroughFields));
    }

    /**
     * Get fake data of WalkThrough
     *
     * @param array $postFields
     * @return array
     */
    public function fakeWalkThroughData($walkThroughFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'sort' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $walkThroughFields);
    }
}
