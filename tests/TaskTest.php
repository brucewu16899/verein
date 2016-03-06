<?php

class TaskTest extends TestCase
{
	/**
	 * Test a simple task creation.
	 */
	public function testCreate()
	{
		$task = $this->createTask();
		$this->assertNotNull($task, 'Task could not be created');
	}

	/**
	 * Test the completion of a task.
	 */
	public function testComplete()
	{
		$user = $this->createUser();
		$task = $this->createTask($user);

		// Complete task
		$this->assertTrue($task
			->complete($user)
			->save());

		$task = \Verein\Task::find(1);
		$this->assertTrue($task->completed);
		$this->assertNotNull($task->completed_at);
		$this->assertEquals(1, $task->completed_by_user_id);
	}

	/**
	 * Test the progress state of a simple task.
	 */
	public function testProgressSimple()
	{
		$user = $this->createUser();

		$taskSimple = $this->createTask($user);
		$this->assertEquals(0, $taskSimple->progress);

		$this->assertTrue($taskSimple
			->complete($user)
			->save());

		$this->assertEquals(100, $taskSimple->progress);
	}

	/**
	 * Test the progress state of a task with jobs.
	 */
	public function testProgressJobs()
	{
		$user = $this->createUser();

		$task = $this->createTask($user);
		$this->createTaskJob($task, $user);
		$this->createTaskJob($task, $user);
		$this->createTaskJob($task, $user);
		$this->createTaskJob($task, $user)->complete($user)->save();
		$this->createTaskJob($task, $user)->complete($user)->save();

		$this->assertEquals(40, $task->progress);
	}
}
