<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubscriberApiTest extends TestCase
{
    use MakeSubscriberTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateSubscriber()
    {
        $subscriber = $this->fakeSubscriberData();
        $this->json('POST', '/api/v1/subscribers', $subscriber);

        $this->assertApiResponse($subscriber);
    }

    /**
     * @test
     */
    public function testReadSubscriber()
    {
        $subscriber = $this->makeSubscriber();
        $this->json('GET', '/api/v1/subscribers/'.$subscriber->id);

        $this->assertApiResponse($subscriber->toArray());
    }

    /**
     * @test
     */
    public function testUpdateSubscriber()
    {
        $subscriber = $this->makeSubscriber();
        $editedSubscriber = $this->fakeSubscriberData();

        $this->json('PUT', '/api/v1/subscribers/'.$subscriber->id, $editedSubscriber);

        $this->assertApiResponse($editedSubscriber);
    }

    /**
     * @test
     */
    public function testDeleteSubscriber()
    {
        $subscriber = $this->makeSubscriber();
        $this->json('DELETE', '/api/v1/subscribers/'.$subscriber->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/subscribers/'.$subscriber->id);

        $this->assertResponseStatus(404);
    }
}
