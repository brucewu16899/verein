<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')
				->unsigned();
			$table->text('title', 255);
			$table->boolean('completed')->default(false);
			$table->timestamp('completed_at')->nullable();
			$table->integer('completed_by_user_id')
				->unsigned()
				->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('completed_by_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});

		Schema::create('tasks_users', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')
				->unsigned();
			$table->integer('task_id')
				->unsigned();
			$table->integer('assigned_user_id')
				->unsigned();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('task_id')
				->references('id')
				->on('tasks')
				->onDelete('cascade');
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('assigned_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});

		Schema::create('tasks_jobs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('task_id')
				->unsigned();
			$table->integer('user_id')
				->unsigned();
			$table->text('title', 255);
			$table->boolean('completed')->default(false);
			$table->timestamp('completed_at')->nullable();
			$table->integer('completed_by_user_id')
				->unsigned()
				->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('task_id')
				->references('id')
				->on('tasks')
				->onDelete('cascade');
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('completed_by_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});

		Schema::create('tasks_jobs_users', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')
				->unsigned();
			$table->integer('task_job_id')
				->unsigned();
			$table->integer('assigned_user_id')
				->unsigned();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('task_job_id')
				->references('id')
				->on('tasks_jobs')
				->onDelete('cascade');
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('assigned_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tasks_jobs_users');
		Schema::drop('tasks_jobs');
		Schema::drop('tasks_users');
		Schema::drop('tasks');
	}

}
