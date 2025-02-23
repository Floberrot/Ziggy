<?php

namespace App\Tests\Functionnal;

use App\Shared\Infrastructure\Factory\OwnerFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;

class ZiggyTestCase extends WebTestCase
{
    use HasBrowser {
        browser as baseKernelBrowser;
    }
    use Factories;

    protected function loginAsOwner(): void
    {
        $owner = OwnerFactory::findOrCreate([
            'email' => 'owner@mail.com',
            'password' => 'password',
        ]);

        $this->browser()->post('api/login', [
            'json' => [
                'email' => $owner->getEmail(),
                'password' => 'password',
            ],
        ])->assertStatus(200);

    }
}
