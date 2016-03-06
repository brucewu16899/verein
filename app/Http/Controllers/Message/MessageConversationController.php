<?php namespace Verein\Http\Controllers\Message;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\Message;
use Verein\MessageConversation;

class MessageConversationController extends Controller
{
	/**
	 * Rules to create a message
	 *
	 * @var array
	 */
	protected $createMessageRules = [
		'to_user_id' => 'required|exists:users,id',
	];

	/**
	 * Create a new controller and set the active tab.
	 */
	public function __construct()
	{
		\Config::set('app.active', 'message');
	}

	/**
	 * List messages.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('message.conversation.index', [
			'messages' => Message::conversations()
				->user()
				->with([
					'sender',
					'receiver',
				])
				->orderBy('updated_at', 'desc')
				->paginate(self::DEFAULT_PAGE_SIZE),
		]);
	}

	/**
	 * Display message details.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$conversation = MessageConversation::where('id', '=', $id)
			->with([
				'messages',
				'messages.sender',
				'messages.receiver',
			])
			->firstOrFail();

		$unread = \DB::table('messages')
			->where('to_user_id', '=', \Sentinel::getUser()->id)
			->where('message_conversation_id', '=', $id)
			->where('read', '=', 0)
			->count();

		if ($unread > 0)
			\DB::table('messages')
				->where('to_user_id', '=', \Sentinel::getUser()->id)
				->where('message_conversation_id', '=', $id)
				->where('read', '=', 0)
				->update([
					'read' => 1,
					'read_at' => \Carbon\Carbon::now(),
				]);

		return view('message.conversation.show', [
			'conversation' => $conversation,
		]);
	}

	/**
	 * Saves a new conversation in the database.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, $this->createMessageRules);

		// Check if conversation already exists
		$conversation = MessageConversation::where('from_user_id', '=', \Sentinel::getUser()->id)
			->where('to_user_id', '=', $request->input('to_user_id'))
			->first();

		if (!isset($conversation)) {
			$conversation = MessageConversation::create([
				'from_user_id' => \Sentinel::getUser()->id,
				'to_user_id' => $request->input('to_user_id'),
			]);
		}

		if (!isset($conversation))
			abort(503);

		return redirect()->route('conversation.show', [
			'conversation' => $conversation->id,
		]);
	}
}
