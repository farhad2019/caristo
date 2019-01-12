<?php

use App\Models\ReviewAspect;
use App\Repositories\Admin\ReviewAspectRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReviewAspectRepositoryTest extends TestCase
{
    use MakeReviewAspectTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var ReviewAspectRepository
     */
    protected $reviewAspectRepo;

    public function setUp()
    {
        parent::setUp();
        $this->reviewAspectRepo = App::make(ReviewAspectRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateReviewAspect()
    {
        $reviewAspect = $this->fakeReviewAspectData();
        $createdReviewAspect = $this->reviewAspectRepo->create($reviewAspect);
        $createdReviewAspect = $createdReviewAspect->toArray();
        $this->assertArrayHasKey('id', $createdReviewAspect);
        $this->assertNotNull($createdReviewAspect['id'], 'Created ReviewAspect must have id specified');
        $this->assertNotNull(ReviewAspect::find($createdReviewAspect['id']), 'ReviewAspect with given id must be in DB');
        $this->assertModelData($reviewAspect, $createdReviewAspect);
    }

    /**
     * @test read
     */
    public function testReadReviewAspect()
    {
        $reviewAspect = $this->makeReviewAspect();
        $dbReviewAspect = $this->reviewAspectRepo->find($reviewAspect->id);
        $dbReviewAspect = $dbReviewAspect->toArray();
        $this->assertModelData($reviewAspect->toArray(), $dbReviewAspect);
    }

    /**
     * @test update
     */
    public function testUpdateReviewAspect()
    {
        $reviewAspect = $this->makeReviewAspect();
        $fakeReviewAspect = $this->fakeReviewAspectData();
        $updatedReviewAspect = $this->reviewAspectRepo->update($fakeReviewAspect, $reviewAspect->id);
        $this->assertModelData($fakeReviewAspect, $updatedReviewAspect->toArray());
        $dbReviewAspect = $this->reviewAspectRepo->find($reviewAspect->id);
        $this->assertModelData($fakeReviewAspect, $dbReviewAspect->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteReviewAspect()
    {
        $reviewAspect = $this->makeReviewAspect();
        $resp = $this->reviewAspectRepo->delete($reviewAspect->id);
        $this->assertTrue($resp);
        $this->assertNull(ReviewAspect::find($reviewAspect->id), 'ReviewAspect should not exist in DB');
    }
}
