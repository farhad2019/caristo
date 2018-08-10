<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsApiTest extends TestCase
{
    use MakeNewsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateNews()
    {
        $news = $this->fakeNewsData();
        $this->json('POST', '/api/v1/news', $news);

        $this->assertApiResponse($news);
    }

    /**
     * @test
     */
    public function testReadNews()
    {
        $news = $this->makeNews();
        $this->json('GET', '/api/v1/news/'.$news->id);

        $this->assertApiResponse($news->toArray());
    }

    /**
     * @test
     */
    public function testUpdateNews()
    {
        $news = $this->makeNews();
        $editedNews = $this->fakeNewsData();

        $this->json('PUT', '/api/v1/news/'.$news->id, $editedNews);

        $this->assertApiResponse($editedNews);
    }

    /**
     * @test
     */
    public function testDeleteNews()
    {
        $news = $this->makeNews();
        $this->json('DELETE', '/api/v1/news/'.$news->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/news/'.$news->id);

        $this->assertResponseStatus(404);
    }
}
