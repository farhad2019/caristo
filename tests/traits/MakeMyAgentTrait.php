<?php

use Faker\Factory as Faker;
use App\Models\MyAgent;
use App\Repositories\Admin\MyAgentRepository;

trait MakeMyAgentTrait
{
    /**
     * Create fake instance of MyAgent and save it in database
     *
     * @param array $myAgentFields
     * @return MyAgent
     */
    public function makeMyAgent($myAgentFields = [])
    {
        /** @var MyAgentRepository $myAgentRepo */
        $myAgentRepo = App::make(MyAgentRepository::class);
        $theme = $this->fakeMyAgentData($myAgentFields);
        return $myAgentRepo->create($theme);
    }

    /**
     * Get fake instance of MyAgent
     *
     * @param array $myAgentFields
     * @return MyAgent
     */
    public function fakeMyAgent($myAgentFields = [])
    {
        return new MyAgent($this->fakeMyAgentData($myAgentFields));
    }

    /**
     * Get fake data of MyAgent
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMyAgentData($myAgentFields = [])
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
        ], $myAgentFields);
    }
}
