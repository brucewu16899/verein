<?php

class MessageTest extends TestCase
{
	/**
	 * Test that a conversation can be created and is not created twice for the same two users.
	 */
	public function testCreateConversation()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$receiver = $this->createUser();

		$this->call('GET', route('user.index'));
		$this->call('POST', route('conversation.store'), [
			'to_user_id' => $receiver->id,
			'_token' => \Session::token(),
		]);
		$this->assertRedirectedToRoute('conversation.show', [
			'conversation' => 1,
		]);

		$this->call('GET', route('user.index'));
		$this->call('POST', route('conversation.store'), [
			'to_user_id' => $receiver->id,
			'_token' => \Session::token(),
		]);
		$this->assertRedirectedToRoute('conversation.show', [
			'conversation' => 1,
		]);
	}

	/**
	 * Test that the conversation index can be viewed.
	 */
	public function testConversationIndex()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$this->createConversation();
		$conversation = $this->createConversation();
		$this->createMessage($conversation);

		$this->call('GET', route('conversation.index'));
		$this->assertResponseOk();
	}

	/**
	 * Test that a conversation can be viewed.
	 */
	public function testConversationShow()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$conversation = $this->createConversation();
		$this->createMessage($conversation);

		$this->call('GET', route('conversation.show', [
			'conversation' => $conversation->id,
		]));
		$this->assertResponseOk();
	}

	/**
	 * Test that a user can write a message.
	 */
	public function testWriteMessage()
	{
		$admin = $this->createSuperuser();
		$this->be($admin);

		$conversation = $this->createConversation($admin);
		$this->createMessage($conversation);

		$this->call('GET', route('conversation.show', [
			'conversation' => $conversation->id,
		]));

		$response = $this->call('POST', route('conversation.message.store', [
			'conversation' => $conversation->id,
		]), [
			'message' => 'Test',
			'_token' => \Session::token(),
		]);
		$this->assertRedirectedToRoute('conversation.show', [
			'conversation' => $conversation->id,
			'#message-2',
		]);
	}
}
