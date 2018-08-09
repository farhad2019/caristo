<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FriendApiTest extends TestCase
{
    use MakeFriendTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateFriend()
    {
        $friend = $this->fakeFriendData();
        $this->json('POST', '/api/v1/friends', $friend);

        $this->assertApiResponse($friend);
    }

    /**
     * @test
     */
    public function testReadFriend()
    {
        $friend = $this->makeFriend();
        $this->json('GET', '/api/v1/friends/'.$friend->id);

        $this->assertApiResponse($friend->toArray());
    }

    /**
     * @test
     */
    public function testUpdateFriend()
    {
        $friend = $this->makeFriend();
        $editedFriend = $this->fakeFriendData();

        $this->json('PUT', '/api/v1/friends/'.$friend->id, $editedFriend);

        $this->assertApiResponse($editedFriend);
    }

    /**
     * @test
     */
    public function testDeleteFriend()
    {
        $friend = $this->makeFriend();
        $this->json('DELETE', '/api/v1/friends/'.$friend->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/friends/'.$friend->id);

        $this->assertResponseStatus(404);
    }
}
