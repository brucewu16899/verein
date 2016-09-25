<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/**
		 * Users
		 */

		// ID 2
		\Verein\User::create([
			'first_name' => 'Arno',
			'last_name' => 'Nym',
			'email' => 'arno@example.com',
			'password' => password_hash('Test', PASSWORD_DEFAULT),
			'last_login' => \Carbon\Carbon::now()->subDays(1),
		]);

		// ID 3
		\Verein\User::create([
			'first_name' => 'Tom',
			'last_name' => 'Test',
			'email' => 'tom@example.com',
			'password' => password_hash('123456', PASSWORD_DEFAULT),
			'comment' => 'IBM',
		]);

		// ID 4
		\Verein\User::create([
			'first_name' => 'Max',
			'last_name' => 'Test',
			'email' => 'max@example.com',
			'password' => password_hash('654321', PASSWORD_DEFAULT),
			'last_login' => \Carbon\Carbon::now()->subDays(12),
		]);

		// ID 5
		\Verein\User::create([
			'first_name' => 'Jack',
			'last_name' => 'Bauer',
			'email' => 'jack@example.com',
			'password' => password_hash('24', PASSWORD_DEFAULT),
			'last_login' => \Carbon\Carbon::now()->subDays(4),
		]);

		// ID 6
		\Verein\User::create([
			'first_name' => 'Katy',
			'last_name' => 'Holmes',
			'email' => 'katy@example.com',
			'password' => password_hash('tom', PASSWORD_DEFAULT),
			'last_login' => \Carbon\Carbon::now()->subDays(3),
		]);

		/**
		 * Members
		 */

		// ID 1
		\Verein\Member::create([
			'first_name' => 'Max',
			'last_name' => 'Black',
			'form_of_address' => 'Prof. Dr.',
			'email' => 'max@example.com',
			'sex' => 'female',
			'birthday' => '1980-04-12',
		]);
	}
}
