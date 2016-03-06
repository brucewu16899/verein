<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// ID 1
		$jsonx = \Verein\Task::create([
			'title' => 'Delete JSONx',
			'user_id' => 1,
		]);

		\Verein\TaskUser::create([
			'task_id' => $jsonx->id,
			'assigned_user_id' => 1,
			'user_id' => 1,
		]);

		// ID 1
		\Verein\TaskJob::create([
			'task_id' => $jsonx->id,
			'title' => 'Find JSONx useless',
			'completed' => 1,
			'completed_at' => \Carbon\Carbon::now()->subDays(15),
			'completed_by_user_id' => 2,
			'user_id' => 1,
		]);

		\Verein\TaskJobUser::create([
			'task_job_id' => 1,
			'assigned_user_id' => 1,
			'user_id' => 1,
		]);

		// ID 2
		\Verein\TaskJob::create([
			'task_id' => $jsonx->id,
			'title' => 'Update documentation',
			'user_id' => 1,
		]);

		\Verein\TaskJobUser::create([
			'task_job_id' => 2,
			'assigned_user_id' => 1,
			'user_id' => 1,
		]);

		// ID 3
		\Verein\TaskJob::create([
			'task_id' => $jsonx->id,
			'title' => 'Inform members via social media',
			'user_id' => 1,
		]);

		// ID 2
		\Verein\Task::create([
			'title' => 'Update logo',
			'user_id' => 1,
		]);

		// ID 3
		\Verein\Task::create([
			'title' => 'Finish VisualAppeal Connect',
			'user_id' => 1,
		]);

		\Verein\TaskUser::create([
			'task_id' => 3,
			'assigned_user_id' => 2,
			'user_id' => 1,
		]);
	}
}
