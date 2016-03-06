<?php

use \Verein\User;

class SuperUserTest extends TestCase
{
	/**
	 * Test that a guest cannot access superuser routes.
	 */
	public function testGuestPermissons()
	{
		$this->call('GET', route('user.index'));
		$this->assertRedirectedToRoute('account.login');
	}

	/**
	 * Test that a normal user cannot access superuser routes.
	 */
	public function testNoPermissons()
	{
		$user = $this->createUser();
		$this->be($user);

		$this->call('GET', route('user.index'));
		$this->assertRedirectedToRoute('dashboard');
	}

	/**
	 * Test that a superuser can access superuser routes.
	 */
	public function testPermissons()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$this->call('GET', route('user.index'));
		$this->assertResponseOk();
	}
}
