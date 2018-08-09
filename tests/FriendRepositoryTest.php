<?php

use App\Models\Friend;
use App\Repositories\Admin\FriendRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FriendRepositoryTest extends TestCase
{
    use MakeFriendTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var FriendRepository
     */
    protected $friendRepo;

    public function setUp()
    {
        parent::setUp();
        $this->friendRepo = App::make(FriendRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateFriend()
    {
        $friend = $this->fakeFriendData();
        $createdFriend = $this->friendRepo->create($friend);
        $createdFriend = $createdFriend->toArray();
        $this->assertArrayHasKey('id', $createdFriend);
        $this->assertNotNull($createdFriend['id'], 'Created Friend must have id specified');
        $this->assertNotNull(Friend::find($createdFriend['id']), 'Friend with given id must be in DB');
        $this->assertModelData($friend, $createdFriend);
    }

    /**
     * @test read
     */
    public function testReadFriend()
    {
        $friend = $this->makeFriend();
        $dbFriend = $this->friendRepo->find($friend->id);
        $dbFriend = $dbFriend->toArray();
        $this->assertModelData($friend->toArray(), $dbFriend);
    }

    /**
     * @test update
     */
    public function testUpdateFriend()
    {
        $friend = $this->makeFriend();
        $fakeFriend = $this->fakeFriendData();
        $updatedFriend = $this->friendRepo->update($fakeFriend, $friend->id);
        $this->assertModelData($fakeFriend, $updatedFriend->toArray());
        $dbFriend = $this->friendRepo->find($friend->id);
        $this->assertModelData($fakeFriend, $dbFriend->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteFriend()
    {
        $friend = $this->makeFriend();
        $resp = $this->friendRepo->delete($friend->id);
        $this->assertTrue($resp);
        $this->assertNull(Friend::find($friend->id), 'Friend should not exist in DB');
    }
}
