<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    public function testTasksCanBeCreated()
    {
        $task1 = 'Task 1';
        $this->json('post', '/task', ['name' => $task1]);
        $this->assertDatabaseHas('tasks', ['name' => $task1]);

    }

    public function testTasksCanBeDisplayedOnDashboard()
    {
        $task1 = 'Task 1';
        $task2 = 'Task 2';
        $task3 = 'Task 2';
        Task::factory()->create(['name' => $task1]);
        Task::factory()->create(['name' => $task2]);
        Task::factory()->create(['name' => $task3]);

        $this->get('/')->assertSee($task1)->assertSee($task2)->assertSee($task3);

    }
}
