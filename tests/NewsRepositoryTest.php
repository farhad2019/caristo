<?php

use App\Models\News;
use App\Repositories\Admin\NewsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsRepositoryTest extends TestCase
{
    use MakeNewsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var NewsRepository
     */
    protected $newsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->newsRepo = App::make(NewsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateNews()
    {
        $news = $this->fakeNewsData();
        $createdNews = $this->newsRepo->create($news);
        $createdNews = $createdNews->toArray();
        $this->assertArrayHasKey('id', $createdNews);
        $this->assertNotNull($createdNews['id'], 'Created News must have id specified');
        $this->assertNotNull(News::find($createdNews['id']), 'News with given id must be in DB');
        $this->assertModelData($news, $createdNews);
    }

    /**
     * @test read
     */
    public function testReadNews()
    {
        $news = $this->makeNews();
        $dbNews = $this->newsRepo->find($news->id);
        $dbNews = $dbNews->toArray();
        $this->assertModelData($news->toArray(), $dbNews);
    }

    /**
     * @test update
     */
    public function testUpdateNews()
    {
        $news = $this->makeNews();
        $fakeNews = $this->fakeNewsData();
        $updatedNews = $this->newsRepo->update($fakeNews, $news->id);
        $this->assertModelData($fakeNews, $updatedNews->toArray());
        $dbNews = $this->newsRepo->find($news->id);
        $this->assertModelData($fakeNews, $dbNews->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteNews()
    {
        $news = $this->makeNews();
        $resp = $this->newsRepo->delete($news->id);
        $this->assertTrue($resp);
        $this->assertNull(News::find($news->id), 'News should not exist in DB');
    }
}
