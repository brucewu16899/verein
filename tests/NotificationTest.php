<?php

use Verein\Notification;

class NotificationTest extends TestCase
{
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
