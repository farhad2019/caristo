<?php

use Faker\Factory as Faker;
use App\Models\MySalesAgent;
use App\Repositories\Admin\MySalesAgentRepository;

trait MakeMySalesAgentTrait
{
    /**
     * Create fake instance of MySalesAgent and save it in database
     *
     * @param array $mySalesAgentFields
     * @return MySalesAgent
     */
    public function makeMySalesAgent($mySalesAgentFields = [])
    {
        /** @var MySalesAgentRepository $mySalesAgentRepo */
        $mySalesAgentRepo = App::make(MySalesAgentRepository::class);
        $theme = $this->fakeMySalesAgentData($mySalesAgentFields);
        return $mySalesAgentRepo->create($theme);
    }

    /**
     * Get fake instance of MySalesAgent
     *
     * @param array $mySalesAgentFields
     * @return MySalesAgent
     */
    public function fakeMySalesAgent($mySalesAgentFields = [])
    {
        return new MySalesAgent($this->fakeMySalesAgentData($mySalesAgentFields));
    }

    /**
     * Get fake data of MySalesAgent
     *
     * @param array $postFields
     * @return array
     */
    public function fakeMySalesAgentData($mySalesAgentFields = [])
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
        ], $mySalesAgentFields);
    }
}
