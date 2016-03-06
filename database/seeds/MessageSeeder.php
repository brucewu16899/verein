<?php

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// 1
		\Verein\MessageConversation::create([
			'from_user_id' => 1,
			'to_user_id' => 2,
		]);

		// 1
		\Verein\Message::create([
			'message_conversation_id' => 1,
			'from_user_id' => 2,
			'to_user_id' => 1,
			'message' => "Hi Tim, how are you? Can we talk later?\n\nKind regards Arno",
			'read' => 1,
			'read_at' => \Carbon\Carbon::now()->subHours(5),
			'created_at' => \Carbon\Carbon::now()->subHours(6),
			'updated_at' => \Carbon\Carbon::now()->subHours(5),
		]);

		// 2
		\Verein\Message::create([
			'message_conversation_id' => 1,
			'from_user_id' => 1,
			'to_user_id' => 2,
			'message' => "Hi Arno,\nThat would be great. Just call me on my smartphone!",
			'read' => 1,
			'read_at' => \Carbon\Carbon::now()->subHours(4),
			'created_at' => \Carbon\Carbon::now()->subHours(5),
			'updated_at' => \Carbon\Carbon::now()->subHours(4),
		]);

		// 3
		\Verein\Message::create([
			'message_conversation_id' => 1,
			'from_user_id' => 2,
			'to_user_id' => 1,
			'message' => "Ok I will call you on your new number.",
			'created_at' => \Carbon\Carbon::now()->subHours(4),
		]);
	}
}
