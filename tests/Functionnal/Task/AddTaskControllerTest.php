<?php

namespace App\Tests\Functionnal\Task;

use App\Tests\Functionnal\ZiggyTestCase;
use Zenstruck\Browser\Json;

class AddTaskControllerTest extends ZiggyTestCase
{
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
        $this->loginAsOwner();
        $this->browser()->post('/api/tasks', [
            'json' => [
                'careType' => 'nope',
            ],
        ])
            ->assertStatus(422)
            ->json();
    }
}
