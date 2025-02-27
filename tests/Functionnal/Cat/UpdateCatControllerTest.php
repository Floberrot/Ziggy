<?php

namespace App\Tests\Functionnal\Cat;

use App\Cat\Domain\Enum\GenderEnum;
use App\Shared\Infrastructure\Factory\CatFactory;
use App\Tests\Functionnal\ZiggyTestCase;

class UpdateCatControllerTest extends ZiggyTestCase
{
    public function testUpdateCatSuccessfully(): void
    {
        $cat = CatFactory::createOne([
            'name' => 'Ziggy',
        ]);

        $this->client->request('PATCH', '/api/cats/' . $cat->getId(), [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Ziggy Updated',
            'breed' => 'Siamese',
            'birthDate' => '2020-06-15',
            'color' => 'gray',
            'weight' => 5.2,
            'gender' => GenderEnum::MALE->value,
        ]));

        $this->assertResponseIsSuccessful();
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals('Ziggy Updated', $result['data']['name']);
        $this->assertEquals('Siamese', $result['data']['breed']);
        $this->assertEquals('2020-06-15 00:00:00', $result['data']['birthDate']);
        $this->assertEquals('gray', $result['data']['color']);
        $this->assertEquals(5.2, $result['data']['weight']);
        $this->assertEquals(GenderEnum::MALE->value, $result['data']['gender']);
    }

    public function testUpdateCatNotFound(): void
    {
        $this->client->request('PATCH', '/api/cats/999', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Unknown',
        ]));

        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(404);
        $this->assertStringContainsString("Cat with id 999 not found", $result['message']);
    }

    public function testUpdateCatWithExistingName(): void
    {
        CatFactory::createOne(['name' => 'Ziggy']);
        $cat = CatFactory::createOne(['name' => 'Milo']);

        $this->client->request('PATCH', '/api/cats/' . $cat->getId(), [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'name' => 'Ziggy',
        ]));

        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(500);
        $this->assertStringContainsString("Key (name)=(Ziggy) already exists.", $result['message']);
    }

    public function testUpdateCatInvalidGender(): void
    {
        $cat = CatFactory::createOne(['name' => 'Ziggy']);

        $this->client->request('PATCH', '/api/cats/' . $cat->getId(), [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'gender' => 'invalid',
        ]));

        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(422);
        $this->assertEquals("The value you selected is not a valid choice. on property : gender. \n", $result['message']);
    }

    public function testUpdateCatInvalidBirthDateFormat(): void
    {
        $cat = CatFactory::createOne(['name' => 'Ziggy']);

        $this->client->request('PATCH', '/api/cats/' . $cat->getId(), [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'birthDate' => '31-01-1998',
        ]));

        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(422);
        $this->assertEquals("This value is not a valid datetime. on property : birthDate. \n", $result['message']);
    }

    public function testPartialUpdateCat(): void
    {
        $cat = CatFactory::createOne([
            'name' => 'Ziggy',
            'color' => 'black',
        ]);

        $this->client->request('PATCH', '/api/cats/' . $cat->getId(), [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'color' => 'white',
        ]));

        $this->assertResponseIsSuccessful();
        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('white', $result['data']['color']);
        $this->assertEquals('Ziggy', $result['data']['name']);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginAsOwner();
    }
}
