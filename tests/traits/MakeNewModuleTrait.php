<?php

use Faker\Factory as Faker;
use App\Models\NewModule;
use App\Repositories\Admin\NewModuleRepository;

trait MakeNewModuleTrait
{
    /**
     * Create fake instance of NewModule and save it in database
     *
     * @param array $newModuleFields
     * @return NewModule
     */
    public function makeNewModule($newModuleFields = [])
    {
        /** @var NewModuleRepository $newModuleRepo */
        $newModuleRepo = App::make(NewModuleRepository::class);
        $theme = $this->fakeNewModuleData($newModuleFields);
        return $newModuleRepo->create($theme);
    }

    /**
     * Get fake instance of NewModule
     *
     * @param array $newModuleFields
     * @return NewModule
     */
    public function fakeNewModule($newModuleFields = [])
    {
        return new NewModule($this->fakeNewModuleData($newModuleFields));
    }

    /**
     * Get fake data of NewModule
     *
     * @param array $postFields
     * @return array
     */
    public function fakeNewModuleData($newModuleFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'slug' => $fake->word,
            'table_name' => $fake->word,
            'icon' => $fake->word,
            'status' => $fake->word,
            'config' => $fake->word,
            'is_protected' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $newModuleFields);
    }
}
