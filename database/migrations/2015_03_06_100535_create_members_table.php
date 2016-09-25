<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')
				->unsigned()
				->nullable();
			$table->string('first_name')->nullable();
			$table->string('middle_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('form_of_address')->nullable();
			$table->string('salutation')->nullable();
			$table->string('email')->nullable();
			$table->text('address')->nullable();
			$table->enum('sex', ['female', 'male'])->nullable();
			$table->date('birthday')->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('set null');
		});

		Schema::create('member_dates', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('member_id')->unsigned();
			$table->integer('user_id')
				->unsigned()
				->nullable();

			$table->enum('type', [
				'private_phone',
				'private_mobile',
				'private_fax',
				'private_email',
				'private_website',
				'private_address',
				'work_phone',
				'work_mobile',
				'work_fax',
				'work_email',
				'work_website',
				'work_address',
			]);
			$table->text('value');

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('member_id')
				->references('id')
				->on('members')
				->onDelete('cascade');
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('set null');
		});

		Schema::create('member_comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('member_id')->unsigned();
			$table->integer('user_id')
				->unsigned()
				->nullable();
			$table->text('comment');

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('member_id')
				->references('id')
				->on('members')
				->onDelete('cascade');
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('set null');
		});

		Schema::table('users', function(Blueprint $table) {
			$table->integer('member_id')
				->unsigned()
				->nullable()
				->after('id');
			$table->string('timezone')
				->default(Config::get('app.timezone'))
				->after('last_name');
			$table->text('comment')
				->nullable()
				->after('timezone');

			$table->softDeletes();

			$table
				->foreign('member_id')
				->references('id')
				->on('members')
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
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_member_id_foreign');

			$table->dropColumn([
				'comment',
				'deleted_at',
				'member_id',
			]);
		});

		Schema::drop('member_dates');
		Schema::drop('member_comments');
		Schema::drop('members');
	}
}
