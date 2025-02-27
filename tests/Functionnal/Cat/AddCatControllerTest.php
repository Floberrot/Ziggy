<?php

namespace App\Tests\Functionnal\Cat;

use App\Cat\Domain\Enum\GenderEnum;
use App\Shared\Infrastructure\Factory\CatFactory;
use App\Tests\Functionnal\ZiggyTestCase;

class AddCatControllerTest extends ZiggyTestCase
{
    public function testAddCat(): void
    {
        $this->client->request('POST', '/api/cats', [
            'name' => 'Ziggy',
            'breed' => 'British',
            'birthDate' => '2021-01-01',
            'color' => 'black',
            "weight" => 4.5,
            'gender' => GenderEnum::FEMALE->value,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('id', $result['data']);
        $this->assertArrayHasKey('name', $result['data']);
        $this->assertArrayHasKey('breed', $result['data']);
        $this->assertArrayHasKey('birthDate', $result['data']);
        $this->assertArrayHasKey('color', $result['data']);
        $this->assertArrayHasKey('weight', $result['data']);
        $this->assertEquals('Ziggy', $result['data']['name']);
        $this->assertEquals('British', $result['data']['breed']);
        $this->assertEquals('2021-01-01 00:00:00', $result['data']['birthDate']);
        $this->assertEquals('black', $result['data']['color']);
        $this->assertEquals(4.5, $result['data']['weight']);
        $this->assertEquals(GenderEnum::FEMALE->value, $result['data']['gender']);
    }

    public function testAddCatButNameAlreadyExist(): void
    {
        CatFactory::createOne([
            'name' => 'Ziggy',
        ]);

        $this->client->request('POST', '/api/cats', [
            'name' => 'Ziggy',
            'gender' => GenderEnum::FEMALE->value,
        ]);

        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(500);
        $this->assertStringContainsString("Key (name)=(Ziggy) already exists.", $result['message']);
    }

    public function testAddCatButGenderIsBad(): void
    {
        $this->client->request('POST', '/api/cats', [
            'name' => 'Ziggy',
            'gender' => 'test',
        ]);
        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(422);
        $this->assertEquals("The value you selected is not a valid choice. on property : gender. \n", $result['message']);
    }

    public function testAddCatButBirthDateBadFormat(): void
    {
        $this->client->request('POST', '/api/cats', [
            'name' => 'Ziggy',
            'gender' => GenderEnum::FEMALE->value,
            'birthDate' => '01-01-2021',
        ]);

        $result = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(422);
        $this->assertEquals("This value is not a valid datetime. on property : birthDate. \n", $result['message']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loginAsOwner();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
