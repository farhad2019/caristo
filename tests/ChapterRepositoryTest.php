<?php

use App\Models\Chapter;
use App\Repositories\Admin\ChapterRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChapterRepositoryTest extends TestCase
{
    use MakeChapterTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ChapterRepository
     */
    protected $chapterRepo;

    public function setUp()
    {
        parent::setUp();
        $this->chapterRepo = App::make(ChapterRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateChapter()
    {
        $chapter = $this->fakeChapterData();
        $createdChapter = $this->chapterRepo->create($chapter);
        $createdChapter = $createdChapter->toArray();
        $this->assertArrayHasKey('id', $createdChapter);
        $this->assertNotNull($createdChapter['id'], 'Created Chapter must have id specified');
        $this->assertNotNull(Chapter::find($createdChapter['id']), 'Chapter with given id must be in DB');
        $this->assertModelData($chapter, $createdChapter);
    }

    /**
     * @test read
     */
    public function testReadChapter()
    {
        $chapter = $this->makeChapter();
        $dbChapter = $this->chapterRepo->find($chapter->id);
        $dbChapter = $dbChapter->toArray();
        $this->assertModelData($chapter->toArray(), $dbChapter);
    }

    /**
     * @test update
     */
    public function testUpdateChapter()
    {
        $chapter = $this->makeChapter();
        $fakeChapter = $this->fakeChapterData();
        $updatedChapter = $this->chapterRepo->update($fakeChapter, $chapter->id);
        $this->assertModelData($fakeChapter, $updatedChapter->toArray());
        $dbChapter = $this->chapterRepo->find($chapter->id);
        $this->assertModelData($fakeChapter, $dbChapter->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteChapter()
    {
        $chapter = $this->makeChapter();
        $resp = $this->chapterRepo->delete($chapter->id);
        $this->assertTrue($resp);
        $this->assertNull(Chapter::find($chapter->id), 'Chapter should not exist in DB');
    }
}
