<?php

class LoginTest extends TestCase
{
	/**
	 * Test that a user has no access to controller actions with auth middleware.
	 */
	public function testNoAccess()
	{
		$this->call('GET', route('dashboard'));
		$this->assertRedirectedToRoute('account.login');
	}

	/**
	 * Test that the user can login.
	 */
	public function testLogin()
	{
		$password = 'ABC123456';
		$user = $this->createUser($password);

		$this->call('GET', route('account.login'));
		$this->assertResponseOk();

		$this->call('POST', route('account.doLogin'), [
			'email' => $user->email,
			'password' => $password,
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('dashboard');
		$this->assertFalse(\Sentinel::guest());
	}

	/**
	 * Test that the user canot login when the account is not activated.
	 */
	public function testLoginNotActivated()
	{
		$password = 'ABC123456';
		$user = $this->createUser($password, false);
		$user->save();

		$this->call('GET', route('account.login'));
		$this->assertResponseOk();

		$response = $this->call('POST', route('account.doLogin'), [
			'email' => $user->email,
			'password' => $password,
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('account.login');
		$this->assertTrue(\Sentinel::guest());
	}

	/**
	 * Test that the user canot login when the account is banned
	 * and can login when its unbanned
	 */
	public function testLoginBan()
	{
		$password = 'ABC123456';
		$user = $this->createUser($password);

		// Account banned
		$user->ban();

		$this->call('GET', route('account.login'));
		$this->assertResponseOk();

		$this->call('POST', route('account.doLogin'), [
			'email' => $user->email,
			'password' => $password,
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('account.login');
		$this->assertTrue(\Sentinel::guest());

		// Account unbanned
		$user->unban();

		$this->call('GET', route('account.login'));
		$this->assertResponseOk();

		$this->call('POST', route('account.doLogin'), [
			'email' => $user->email,
			'password' => $password,
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('dashboard');
		$this->assertFalse(\Sentinel::guest());
	}

	/**
	 * Test that the user can't login with a wrong email.
	 */
	public function testLoginWrongEmail()
	{
		$password = 'ABC123456';
		$user = $this->createUser($password);

		$this->call('GET', route('account.login'));
		$this->assertResponseOk();

		$this->call('POST', route('account.doLogin'), [
			'email' => $user->email . 'WRONG',
			'password' => $password,
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('account.login');
		$this->assertTrue(\Sentinel::guest());
	}

	/**
	 * Test that the user can't login with a wrong password.
	 */
	public function testLoginWrongPassword()
	{
		$password = 'ABC123456';
		$user = $this->createUser($password);

		$this->call('GET', route('account.login'));
		$this->assertResponseOk();

		$this->call('POST', route('account.doLogin'), [
			'email' => $user->email,
			'password' => $password . 'WRONG',
			'_token' => Session::token(),
		]);

		$this->assertRedirectedToRoute('account.login');
		$this->assertTrue(\Sentinel::guest());
	}
}
