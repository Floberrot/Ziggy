<?php

namespace App\Tests\Functionnal\Task;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Json;
use Zenstruck\Browser\Test\HasBrowser;

class AddTaskControllerTest extends WebTestCase
{
    use HasBrowser {
        browser as baseKernelBrowser;
    }

    public function testAddTask(): void
    {
        $response = $this->browser()->post('/api/tasks', [
            'json' => [
                'careType' => 'feeding',
            ],
        ])
            ->assertStatus(201)
            ->json();

        $response->assertThat('message', fn (Json $message) => $this->assertEquals('Task added', $message->decoded()));
        $response->assertThat('data', fn (Json $data) => $this->assertEquals('feeding', $data->decoded()['careType']));
        $response->assertThat('data', fn (Json $data) => $this->assertArrayHasKey('id', $data->decoded()));
    }

    public function testAddTasButCareTypeNotFound(): void
    {
        $this->browser()->post('/api/tasks', [
            'json' => [
                'careType' => 'nope',
            ],
        ])
            ->assertStatus(422)
            ->json();
    }

}
