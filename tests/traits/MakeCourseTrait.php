<?php

use Faker\Factory as Faker;
use App\Models\Course;
use App\Repositories\Admin\CourseRepository;

trait MakeCourseTrait
{
    /**
     * Create fake instance of Course and save it in database
     *
     * @param array $courseFields
     * @return Course
     */
    public function makeCourse($courseFields = [])
    {
        /** @var CourseRepository $courseRepo */
        $courseRepo = App::make(CourseRepository::class);
        $theme = $this->fakeCourseData($courseFields);
        return $courseRepo->create($theme);
    }

    /**
     * Get fake instance of Course
     *
     * @param array $courseFields
     * @return Course
     */
    public function fakeCourse($courseFields = [])
    {
        return new Course($this->fakeCourseData($courseFields));
    }

    /**
     * Get fake data of Course
     *
     * @param array $postFields
     * @return array
     */
    public function fakeCourseData($courseFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'category_id' => $fake->word,
            'latitude' => $fake->randomDigitNotNull,
            'longitude' => $fake->randomDigitNotNull,
            'location' => $fake->word,
            'language' => $fake->word,
            'duration' => $fake->word,
            'date' => $fake->word,
            'time' => $fake->word,
            'price' => $fake->word,
            'currency' => $fake->word,
            'intro_link' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $courseFields);
    }
}
