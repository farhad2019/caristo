<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ChapterApiTest extends TestCase
{
    use MakeChapterTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateChapter()
    {
        $chapter = $this->fakeChapterData();
        $this->json('POST', '/api/v1/chapters', $chapter);

        $this->assertApiResponse($chapter);
    }

    /**
     * @test
     */
    public function testReadChapter()
    {
        $chapter = $this->makeChapter();
        $this->json('GET', '/api/v1/chapters/'.$chapter->id);

        $this->assertApiResponse($chapter->toArray());
    }

    /**
     * @test
     */
    public function testUpdateChapter()
    {
        $chapter = $this->makeChapter();
        $editedChapter = $this->fakeChapterData();

        $this->json('PUT', '/api/v1/chapters/'.$chapter->id, $editedChapter);

        $this->assertApiResponse($editedChapter);
    }

    /**
     * @test
     */
    public function testDeleteChapter()
    {
        $chapter = $this->makeChapter();
        $this->json('DELETE', '/api/v1/chapters/'.$chapter->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/chapters/'.$chapter->id);

        $this->assertResponseStatus(404);
    }
}
