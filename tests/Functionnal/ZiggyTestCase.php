<?php

namespace App\Tests\Functionnal;

use App\Shared\Infrastructure\Factory\OwnerFactory;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Zenstruck\Foundry\Test\Factories;

class ZiggyTestCase extends WebTestCase
{
    use Factories;

    protected ?KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createClient();
    }

    protected function loginAsOwner(): void
    {
        $owner = OwnerFactory::findOrCreate([
            'email' => 'owner@mail.com',
            'password' => 'password',
        ]);

        $this->client->loginUser($owner);
        $container = $this->client->getContainer();
        $security = $this->createMock(Security::class);
        $security->method('getUser')->willReturn($owner);
        $container->set(Security::class, $security);

        $this->assertNotEmpty($this->client->getCookieJar()->all());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        self::ensureKernelShutdown();
        $this->client = null;
    }
}
