<?php

namespace App\Tests\Functionnal\Task;

use App\Shared\Infrastructure\Factory\OwnerFactory;
use App\Tests\Functionnal\ZiggyTestCase;

class AddTaskControllerTest extends ZiggyTestCase
{
    public function testAddTask(): void
    {
        $this->client->request('POST', '/api/tasks', [
            'careType' => 'feeding',
        ]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('application/json', $this->client->getResponse()->headers->get('Content-Type'));
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('id', $result['data']);
        $this->assertArrayHasKey('careType', $result['data']);
        $this->assertArrayHasKey('done', $result['data']);
        $this->assertArrayHasKey('comment', $result['data']);
        $this->assertEquals('feeding', $result['data']['careType']);
        $this->assertEquals('Task added', $result['message']);
    }

    public function testAddTaskButCareTypeEnumIsNotValid(): void
    {
        $this->client->request('POST', '/api/tasks', [
            'careType' => 'invalid',
        ]);

        $this->assertEquals(422, $this->client->getResponse()->getStatusCode());
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals("The value you selected is not a valid choice. on property : careType. \n", $result['message']);
    }

    public function testAddTaskWithOwnerSet(): void
    {
        $newOwner = OwnerFactory::createOne();

        $this->client->request('POST', '/api/tasks', [
            'careType' => 'feeding',
            'ownerId' => $newOwner->getId(),
        ]);

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('owner', $result['data']);
        $this->assertEquals($newOwner->getId(), $result['data']['owner']['id']);
        $this->assertEquals($newOwner->getEmail(), $result['data']['owner']['email']);
        $this->assertEquals($newOwner->getFirstName(), $result['data']['owner']['firstName']);
        $this->assertEquals($newOwner->getLastName(), $result['data']['owner']['lastName']);
    }

    public function testAddTaskButOwnerNotFound(): void
    {
        $this->client->request('POST', '/api/tasks', [
            'careType' => 'feeding',
            'ownerId' => 99999999,
        ]);

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertStringContainsString("Owner not found with id: 9999999", $result['message']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loginAsOwner();
    }
}
