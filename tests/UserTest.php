<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

use \Verein\User;

class UserTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * Test that the user get logged out.
	 */
	public function testLogout()
	{
		$user = $this->createUser();
		$this->be($user);

		$response = $this->call('GET', route('dashboard'));
		$this->assertResponseOk();

		$this->call('GET', route('account.logout'));
		$this->assertResponseStatus(302);

		$response = $this->call('GET', route('dashboard'));
		$this->assertRedirectedToRoute('account.login');
	}

	/**
	 * Test that the index page loads and contains user data.
	 */
	public function testIndex()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$user1 = $this->createUser();
		$user2 = $this->createUser();

		$response = $this->call('GET', route('user.index'));
		$this->assertResponseOk();
		$this->assertContains($user1->name, $response->getContent());
		$this->assertContains($user2->name, $response->getContent());
	}

	/**
	 * Test that the user page loads and contains the user name.
	 */
	public function testShow()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$user = $this->createUser();

		$response = $this->call('GET', route('user.show', [
			'user' => $user->id,
		]));
		$this->assertResponseOk();
		$this->assertContains($user->name, $response->getContent());
	}

	/**
	 * Test if the user can be banned.
	 */
	public function testBan()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$user = $this->createUser();

		$this->assertFalse($user->isBanned);

		$this->call('GET', route('user.show', [
			'user' => $user->id
		]));
		$this->call('POST', route('user.ban', [
			'user' => $user->id,
		]), [
			'_token' => Session::token(),
		]);

		$this->assertTrue($user->isBanned);
	}

	/**
	 * Test if the user can be unbanned.
	 */
	public function testUnban()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$user = $this->createUser();
		$user->ban();

		$this->assertTrue($user->isBanned);

		$this->call('GET', route('user.show', [
			'user' => $user->id
		]));
		$this->call('POST', route('user.unban', [
			'user' => $user->id,
		]), [
			'_token' => Session::token(),
		]);

		$this->assertFalse($user->isBanned);
	}

	/**
	 * Test if the user can be activated.
	 */
	public function testActivate()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$user = $this->createUser('123456', false);

		$this->assertFalse($user->isActivated);

		$this->call('GET', route('user.show', [
			'user' => $user->id
		]));
		$response = $this->call('POST', route('user.activate', [
			'user' => $user->id,
		]), [
			'_token' => Session::token(),
		]);

		$user = \Verein\User::findOrFail($user->id);
		$this->assertTrue($user->isActivated);
	}
}
