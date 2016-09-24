<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call('AdminSeeder');

		if (Config::get('app.env') == 'development') {
			$this->call('UserSeeder');
			$this->call('ConversationSeeder');
		}
	}
}
