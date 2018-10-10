<?php

use Faker\Factory as Faker;
use App\Models\RegionalSpecification;
use App\Repositories\Admin\RegionalSpecificationRepository;

trait MakeRegionalSpecificationTrait
{
    /**
     * Create fake instance of RegionalSpecification and save it in database
     *
     * @param array $regionalSpecificationFields
     * @return RegionalSpecification
     */
    public function makeRegionalSpecification($regionalSpecificationFields = [])
    {
        /** @var RegionalSpecificationRepository $regionalSpecificationRepo */
        $regionalSpecificationRepo = App::make(RegionalSpecificationRepository::class);
        $theme = $this->fakeRegionalSpecificationData($regionalSpecificationFields);
        return $regionalSpecificationRepo->create($theme);
    }

    /**
     * Get fake instance of RegionalSpecification
     *
     * @param array $regionalSpecificationFields
     * @return RegionalSpecification
     */
    public function fakeRegionalSpecification($regionalSpecificationFields = [])
    {
        return new RegionalSpecification($this->fakeRegionalSpecificationData($regionalSpecificationFields));
    }

    /**
     * Get fake data of RegionalSpecification
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRegionalSpecificationData($regionalSpecificationFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $regionalSpecificationFields);
    }
}
