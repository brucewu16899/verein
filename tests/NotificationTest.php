<?php

use Verein\Notification;

class NotificationTest extends TestCase
{
	/**
	 * Ensure that a notification is created for an assigend task.
	 */
	public function testTaskAssignedNotification()
	{
		$user1 = $this->createUser();
		$user2 = $this->createUser();

		// User 1 creates a new task
		$task = \Verein\Task::create([
			'user_id' => $user1->id,
			'title' => 'Test Task',
		]);

		// User 2 assignes user 1 to the task
		\Verein\TaskUser::create([
			'task_id' => $task->id,
			'user_id' => $user2->id,
			'assigned_user_id' => $user1->id,
		]);

		// Notification for user 1 that user 2 has assigned him to the task
		$notification = Notification::find(1);
		$this->assertNotNull($notification, 'No notification created');

		$this->assertEquals($user2->id, $notification->from_user_id);
		$this->assertEquals($user1->id, $notification->to_user_id);
	}

	/**
	 * Ensure that a notification is created for an assigend job.
	 */
	public function testTaskJobAssignedNotification()
	{
		$user1 = $this->createUser();
		$user2 = $this->createUser();

		// User 1 creates a task
		$task = \Verein\Task::create([
			'user_id' => $user1->id,
			'title' => 'Test Task',
		]);

		// User 1 creates a job for this task
		$job = \Verein\TaskJob::create([
			'user_id' => $user1->id,
			'task_id' => $task->id,
			'title' => 'Test Job',
		]);

		// User 2 assignes user 1 for this job
		\Verein\TaskJobUser::create([
			'task_job_id' => $job->id,
			'user_id' => $user2->id,
			'assigned_user_id' => $user1->id,
		]);

		// Notification for user 1 that user 2 has assigned him to the job
		$notification = Notification::find(1);
		$this->assertNotNull($notification, 'No notification created');

		$this->assertEquals($user2->id, $notification->from_user_id);
		$this->assertEquals($user1->id, $notification->to_user_id);
	}

	/**
	 * Ensure that a notification is created for a newly created job.
	 */
	public function testTaskJobCreatedNotification()
	{
		$user1 = $this->createUser();
		$user2 = $this->createUser();

		// User 1 creates a new task
		$task = \Verein\Task::create([
			'user_id' => $user1->id,
			'title' => 'Test Task',
		]);

		// User 1 assignes himself to the task
		\Verein\TaskUser::create([
			'task_id' => $task->id,
			'user_id' => $user1->id,
			'assigned_user_id' => $user1->id,
		]);

		// User 2 creates a new job for this task
		$job = \Verein\TaskJob::create([
			'user_id' => $user2->id,
			'task_id' => $task->id,
			'title' => 'Test Job',
		]);

		// Notification for user 1 that a new job was created for his task
		$notification = Notification::find(1);
		$this->assertNotNull($notification, 'No Notification created');

		$this->assertEquals($user2->id, $notification->from_user_id);
		$this->assertEquals($user1->id, $notification->to_user_id);
	}

	/**
	 * Label notification as from view.
	 */
	public function testNotificationRead()
	{
		$notification = $this->createNotification();

		// Test if notification was created as unread
		$this->assertFalse($notification->read);
		$this->assertNull($notification->read_at);

		// Label read
		$admin = $this->createSuperuser();
		$this->be($admin);

		$response = $this->call('GET', route('notification.read', [
			'notification' => $notification->id,
		]));
		$this->assertResponseStatus(302);

		$notification = Notification::find(1);

		$this->assertTrue($notification->read);
		$this->assertNotNull($notification->read_at);
	}

	/**
	 * Label notification as unread.
	 */
	public function testNotificationUnread()
	{
		$notification = $this->createNotification();

		// Set to read
		$this->assertTrue($notification
			->labelRead()
			->save());

		// Label unread
		$admin = $this->createSuperuser();
		$this->be($admin);

		$this->call('GET', route('notification.unread', [
			'notification' => $notification->id,
		]));
		$this->assertResponseStatus(302);

		$notification = Notification::find(1);

		$this->assertFalse($notification->read);
		$this->assertNull($notification->read_at);
	}
}
