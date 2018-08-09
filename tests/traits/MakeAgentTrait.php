<?php

use Faker\Factory as Faker;
use App\Models\Agent;
use App\Repositories\Admin\AgentRepository;

trait MakeAgentTrait
{
    /**
     * Create fake instance of Agent and save it in database
     *
     * @param array $agentFields
     * @return Agent
     */
    public function makeAgent($agentFields = [])
    {
        /** @var AgentRepository $agentRepo */
        $agentRepo = App::make(AgentRepository::class);
        $theme = $this->fakeAgentData($agentFields);
        return $agentRepo->create($theme);
    }

    /**
     * Get fake instance of Agent
     *
     * @param array $agentFields
     * @return Agent
     */
    public function fakeAgent($agentFields = [])
    {
        return new Agent($this->fakeAgentData($agentFields));
    }

    /**
     * Get fake data of Agent
     *
     * @param array $postFields
     * @return array
     */
    public function fakeAgentData($agentFields = [])
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
        ], $agentFields);
    }
}
