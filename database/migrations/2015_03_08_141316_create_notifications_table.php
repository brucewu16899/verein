<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('from_user_id')
				->unsigned()
				->nullable(); // NULL if message is from the system
			$table->integer('to_user_id')
				->unsigned();
			$table->string('icon');
			$table->text('message');
			$table->text('message_parameters');
			$table->text('url');
			$table->text('url_parameters');
			$table->boolean('read')->default(false);
			$table->timestamp('read_at')->nullable();

			$table->timestamps();

			$table->index('from_user_id');
			$table->index('to_user_id');
			$table->foreign('from_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('to_user_id')
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
		Schema::drop('notifications');
	}
}
