<?php namespace Verein\Http\Controllers\Message;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\Message;
use Verein\MessageConversation;

class MessageController extends Controller
{
	/**
	 * Rules to create a message
	 *
	 * @var array
	 */
	protected $createMessageRules = [
		'message' => 'required',
	];

	/**
	 * Create a new controller and set the active tab.
	 */
	public function __construct()
	{
		\Config::set('app.active', 'message');
	}

	/**
	 * Validate the input and store the message in the database.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $conversationId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $conversationId)
	{
		$conversation = MessageConversation::findOrFail($conversationId);
		if ($conversation->from_user_id != \Sentinel::getUser()->id &&
			$conversation->to_user_id != \Sentinel::getUser()->id)
			abort(403);

		$this->validate($request, $this->createMessageRules);

		$toUserId = ($conversation->from_user_id == \Sentinel::getUser()->id)
			? $conversation->to_user_id
			: $conversation->from_user_id;

		$message = Message::create([
			'message_conversation_id' => $conversationId,
			'from_user_id' => \Sentinel::getUser()->id,
			'to_user_id' => $toUserId,
			'message' => $request->input('message'),
		]);

		if (!isset($message))
			abort(503);

		$conversation->touch();

		return redirect()->route('conversation.show', [
			'conversation' => $message->message_conversation_id,
			'#message-' . $message->id,
		]);
	}
}
