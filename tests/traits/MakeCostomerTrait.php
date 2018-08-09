<?php

use Faker\Factory as Faker;
use App\Models\Costomer;
use App\Repositories\Admin\CostomerRepository;

trait MakeCostomerTrait
{
    /**
     * Create fake instance of Costomer and save it in database
     *
     * @param array $costomerFields
     * @return Costomer
     */
    public function makeCostomer($costomerFields = [])
    {
        /** @var CostomerRepository $costomerRepo */
        $costomerRepo = App::make(CostomerRepository::class);
        $theme = $this->fakeCostomerData($costomerFields);
        return $costomerRepo->create($theme);
    }

    /**
     * Get fake instance of Costomer
     *
     * @param array $costomerFields
     * @return Costomer
     */
    public function fakeCostomer($costomerFields = [])
    {
        return new Costomer($this->fakeCostomerData($costomerFields));
    }

    /**
     * Get fake data of Costomer
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCostomerData($costomerFields = [])
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
        ], $costomerFields);
    }
}
