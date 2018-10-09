<?php

use Faker\Factory as Faker;
use App\Models\EngineType;
use App\Repositories\Admin\EngineTypeRepository;

trait MakeEngineTypeTrait
{
    /**
     * Create fake instance of EngineType and save it in database
     *
     * @param array $engineTypeFields
     * @return EngineType
     */
    public function makeEngineType($engineTypeFields = [])
    {
        /** @var EngineTypeRepository $engineTypeRepo */
        $engineTypeRepo = App::make(EngineTypeRepository::class);
        $theme = $this->fakeEngineTypeData($engineTypeFields);
        return $engineTypeRepo->create($theme);
    }

    /**
     * Get fake instance of EngineType
     *
     * @param array $engineTypeFields
     * @return EngineType
     */
    public function fakeEngineType($engineTypeFields = [])
    {
        return new EngineType($this->fakeEngineTypeData($engineTypeFields));
    }

    /**
     * Get fake data of EngineType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeEngineTypeData($engineTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $engineTypeFields);
    }
}
