<?php

use Faker\Factory as Faker;
use App\Models\Manager;
use App\Repositories\Admin\ManagerRepository;

trait MakeManagerTrait
{
    /**
     * Create fake instance of Manager and save it in database
     *
     * @param array $managerFields
     * @return Manager
     */
    public function makeManager($managerFields = [])
    {
        /** @var ManagerRepository $managerRepo */
        $managerRepo = App::make(ManagerRepository::class);
        $theme = $this->fakeManagerData($managerFields);
        return $managerRepo->create($theme);
    }

    /**
     * Get fake instance of Manager
     *
     * @param array $managerFields
     * @return Manager
     */
    public function fakeManager($managerFields = [])
    {
        return new Manager($this->fakeManagerData($managerFields));
    }

    /**
     * Get fake data of Manager
     *
     * @param array $postFields
     * @return array
     */
    public function fakeManagerData($managerFields = [])
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
        ], $managerFields);
    }
}
