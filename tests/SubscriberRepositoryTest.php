<?php

use App\Models\Subscriber;
use App\Repositories\Admin\SubscriberRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscriberRepositoryTest extends TestCase
{
    use MakeSubscriberTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var SubscriberRepository
     */
    protected $subscriberRepo;

    public function setUp()
    {
        parent::setUp();
        $this->subscriberRepo = App::make(SubscriberRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateSubscriber()
    {
        $subscriber = $this->fakeSubscriberData();
        $createdSubscriber = $this->subscriberRepo->create($subscriber);
        $createdSubscriber = $createdSubscriber->toArray();
        $this->assertArrayHasKey('id', $createdSubscriber);
        $this->assertNotNull($createdSubscriber['id'], 'Created Subscriber must have id specified');
        $this->assertNotNull(Subscriber::find($createdSubscriber['id']), 'Subscriber with given id must be in DB');
        $this->assertModelData($subscriber, $createdSubscriber);
    }

    /**
     * @test read
     */
    public function testReadSubscriber()
    {
        $subscriber = $this->makeSubscriber();
        $dbSubscriber = $this->subscriberRepo->find($subscriber->id);
        $dbSubscriber = $dbSubscriber->toArray();
        $this->assertModelData($subscriber->toArray(), $dbSubscriber);
    }

    /**
     * @test update
     */
    public function testUpdateSubscriber()
    {
        $subscriber = $this->makeSubscriber();
        $fakeSubscriber = $this->fakeSubscriberData();
        $updatedSubscriber = $this->subscriberRepo->update($fakeSubscriber, $subscriber->id);
        $this->assertModelData($fakeSubscriber, $updatedSubscriber->toArray());
        $dbSubscriber = $this->subscriberRepo->find($subscriber->id);
        $this->assertModelData($fakeSubscriber, $dbSubscriber->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteSubscriber()
    {
        $subscriber = $this->makeSubscriber();
        $resp = $this->subscriberRepo->delete($subscriber->id);
        $this->assertTrue($resp);
        $this->assertNull(Subscriber::find($subscriber->id), 'Subscriber should not exist in DB');
    }
}
