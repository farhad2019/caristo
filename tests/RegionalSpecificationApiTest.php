<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegionalSpecificationApiTest extends TestCase
{
    use MakeRegionalSpecificationTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateRegionalSpecification()
    {
        $regionalSpecification = $this->fakeRegionalSpecificationData();
        $this->json('POST', '/api/v1/regionalSpecifications', $regionalSpecification);

        $this->assertApiResponse($regionalSpecification);
    }

    /**
     * @test
     */
    public function testReadRegionalSpecification()
    {
        $regionalSpecification = $this->makeRegionalSpecification();
        $this->json('GET', '/api/v1/regionalSpecifications/'.$regionalSpecification->id);

        $this->assertApiResponse($regionalSpecification->toArray());
    }

    /**
     * @test
     */
    public function testUpdateRegionalSpecification()
    {
        $regionalSpecification = $this->makeRegionalSpecification();
        $editedRegionalSpecification = $this->fakeRegionalSpecificationData();

        $this->json('PUT', '/api/v1/regionalSpecifications/'.$regionalSpecification->id, $editedRegionalSpecification);

        $this->assertApiResponse($editedRegionalSpecification);
    }

    /**
     * @test
     */
    public function testDeleteRegionalSpecification()
    {
        $regionalSpecification = $this->makeRegionalSpecification();
        $this->json('DELETE', '/api/v1/regionalSpecifications/'.$regionalSpecification->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/regionalSpecifications/'.$regionalSpecification->id);

        $this->assertResponseStatus(404);
    }
}
