<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class DashboardTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test that guests has no access to the dashboard.
	 */
	public function testNoAccess()
	{
		$this->call('GET', route('dashboard'));
		$this->assertRedirectedToRoute('account.login');
	}

	/**
	 * Test that users can view the dashboard.
	 */
	public function testDashboard()
	{
		$user = $this->createUser();
		$this->be($user);

		$this->call('GET', route('dashboard'));
		$this->assertResponseOk();
	}
}
