<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// ID 1
		$admin = \Sentinel::registerAndActivate([
			'email' => env('ADMIN_EMAIL'),
			'password' => env('ADMIN_PASSWORD'),
			'timezone' => env('ADMIN_TIMEZONE'),
		]);

		// ID 1
		$adminRole = \Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'Superuser',
			'slug' => 'superuser',
		]);

		$adminRole->addPermission('superuser')->save();

		$adminRole->users()->attach($admin);
	}
}
