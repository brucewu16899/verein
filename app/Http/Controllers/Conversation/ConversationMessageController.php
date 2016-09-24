<?php namespace Verein\Http\Controllers\Conversation;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\ConversationMessage;
use Verein\Conversation;

class ConversationMessageController extends Controller
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
		$conversation = Conversation::findOrFail($conversationId);
		if ($conversation->from_user_id != \Sentinel::getUser()->id &&
			$conversation->to_user_id != \Sentinel::getUser()->id)
			abort(403);

		$this->validate($request, $this->createMessageRules);

		$toUserId = ($conversation->from_user_id == \Sentinel::getUser()->id)
			? $conversation->to_user_id
			: $conversation->from_user_id;

		$message = ConversationMessage::create([
			'conversation_id' => $conversation->id,
			'from_user_id' => \Sentinel::getUser()->id,
			'to_user_id' => $toUserId,
			'message' => $request->input('message'),
		]);

		if (!isset($message))
			abort(503);

		$conversation->touch();

		return redirect()->route('conversation.show', [
			'conversation' => $conversation->id,
			'#message-' . $message->id,
		]);
	}
}
