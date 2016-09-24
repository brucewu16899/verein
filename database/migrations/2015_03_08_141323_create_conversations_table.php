<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('from_user_id')->unsigned();
			$table->integer('to_user_id')->unsigned();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('from_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			$table->foreign('to_user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
		});

		Schema::create('conversation_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('conversation_id')->unsigned();
			$table->integer('from_user_id')->unsigned();
			$table->integer('to_user_id')->unsigned();
			$table->text('message');
			$table->boolean('read')->default(false);
			$table->timestamp('read_at')->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('conversation_id')
				->references('id')
				->on('conversations')
				->onDelete('cascade');
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
		Schema::drop('conversation_messages');
		Schema::drop('conversations');
	}

}
