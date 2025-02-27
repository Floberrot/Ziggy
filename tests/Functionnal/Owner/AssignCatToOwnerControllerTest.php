<?php

namespace App\Tests\Functionnal\Owner;

use App\Shared\Infrastructure\Factory\CatFactory;
use App\Shared\Infrastructure\Factory\OwnerFactory;
use App\Shared\Infrastructure\Factory\SitterFactory;
use App\Tests\Functionnal\ZiggyTestCase;

class AssignCatToOwnerControllerTest extends ZiggyTestCase
{
    public function testAssignCatToOwner(): void
    {
        $owner = OwnerFactory::createOne();
        $cat = CatFactory::createOne();

        $this->client->request('PUT', "/api/owners/{$owner->getId()}/cats/{$cat->getId()}");

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('id', $result['data']);
        $this->assertArrayHasKey('cats', $result['data']);
        $this->assertIsArray($result['data']['cats']);
        $this->assertCount(1, $result['data']['cats']);
        $this->assertEquals($cat->getId(), $result['data']['cats'][0]['id']);

    }

    public function testAssignCatToOwnerButItsNotAnOwner(): void
    {
        $notOwner = SitterFactory::createOne();
        $cat = CatFactory::createOne();

        $this->client->request('PUT', "/api/owners/{$notOwner->getId()}/cats/{$cat->getId()}");

        $this->assertResponseStatusCodeSame(404);
        $this->assertStringContainsString("Owner {$notOwner->getId()} not found", $this->client->getResponse()->getContent());
    }

    public function testAssignCatToOwnerButCatNotFound(): void
    {
        $owner = OwnerFactory::createOne();

        $this->client->request('PUT', "/api/owners/{$owner->getId()}/cats/999");

        $this->assertResponseStatusCodeSame(404);
        $this->assertStringContainsString("Cat with id 999 not found", $this->client->getResponse()->getContent());
    }

    public function testAssignCatToOwnerButOwnerNotFound(): void
    {
        $cat = CatFactory::createOne();

        $this->client->request('PUT', "/api/owners/999/cats/{$cat->getId()}");

        $this->assertResponseStatusCodeSame(404);
        $this->assertStringContainsString("Owner 999 not found", $this->client->getResponse()->getContent());
    }

    public function testAssignCatToOwnerButCatAlreadyAssigned(): void
    {
        $cat = CatFactory::createOne();
        $owner = OwnerFactory::createOne([
            'cats' => [$cat],
        ]);

        $this->client->request('PUT', "/api/owners/{$owner->getId()}/cats/{$cat->getId()}");

        $this->assertResponseStatusCodeSame(400);
        $this->assertStringContainsString("Cat with id {$cat->getId()} is already assigned to owner with id {$owner->getId()}", $this->client->getResponse()->getContent());
    }
}
