<?php

use Faker\Factory as Faker;
use App\Models\Friend;
use App\Repositories\Admin\FriendRepository;

trait MakeFriendTrait
{
    /**
     * Create fake instance of Friend and save it in database
     *
     * @param array $friendFields
     * @return Friend
     */
    public function makeFriend($friendFields = [])
    {
        /** @var FriendRepository $friendRepo */
        $friendRepo = App::make(FriendRepository::class);
        $theme = $this->fakeFriendData($friendFields);
        return $friendRepo->create($theme);
    }

    /**
     * Get fake instance of Friend
     *
     * @param array $friendFields
     * @return Friend
     */
    public function fakeFriend($friendFields = [])
    {
        return new Friend($this->fakeFriendData($friendFields));
    }

    /**
     * Get fake data of Friend
     *
     * @param array $postFields
     * @return array
     */
    public function fakeFriendData($friendFields = [])
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
        ], $friendFields);
    }
}
