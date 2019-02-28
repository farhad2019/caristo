<?php

use Faker\Factory as Faker;
use App\Models\Chapter;
use App\Repositories\Admin\ChapterRepository;

trait MakeChapterTrait
{
    /**
     * Create fake instance of Chapter and save it in database
     *
     * @param array $chapterFields
     * @return Chapter
     */
    public function makeChapter($chapterFields = [])
    {
        /** @var ChapterRepository $chapterRepo */
        $chapterRepo = App::make(ChapterRepository::class);
        $theme = $this->fakeChapterData($chapterFields);
        return $chapterRepo->create($theme);
    }

    /**
     * Get fake instance of Chapter
     *
     * @param array $chapterFields
     * @return Chapter
     */
    public function fakeChapter($chapterFields = [])
    {
        return new Chapter($this->fakeChapterData($chapterFields));
    }

    /**
     * Get fake data of Chapter
     *
     * @param array $postFields
     * @return array
     */
    public function fakeChapterData($chapterFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'course_id' => $fake->word,
            'link' => $fake->word,
            'created_at' => $fake->date('Y-m-d H:i:s'),
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $chapterFields);
    }
}
