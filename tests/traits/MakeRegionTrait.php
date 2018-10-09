<?php

use Faker\Factory as Faker;
use App\Models\Region;
use App\Repositories\Admin\RegionRepository;

trait MakeRegionTrait
{
    /**
     * Create fake instance of Region and save it in database
     *
     * @param array $regionFields
     * @return Region
     */
    public function makeRegion($regionFields = [])
    {
        /** @var RegionRepository $regionRepo */
        $regionRepo = App::make(RegionRepository::class);
        $theme = $this->fakeRegionData($regionFields);
        return $regionRepo->create($theme);
    }

    /**
     * Get fake instance of Region
     *
     * @param array $regionFields
     * @return Region
     */
    public function fakeRegion($regionFields = [])
    {
        return new Region($this->fakeRegionData($regionFields));
    }

    /**
     * Get fake data of Region
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRegionData($regionFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $regionFields);
    }
}
