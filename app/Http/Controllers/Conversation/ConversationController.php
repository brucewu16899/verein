<?php namespace Verein\Http\Controllers\Conversation;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\ConversationMessage;
use Verein\Conversation;

class ConversationController extends Controller
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
		return view('conversation.index', [
			'conversations' => Conversation::user()
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
		$conversation = Conversation::where('id', '=', $id)
			->with([
				'messages',
				'messages.sender',
				'messages.receiver',
			])
			->firstOrFail();

		$unread = \DB::table('conversation_messages')
			->where('to_user_id', '=', \Sentinel::getUser()->id)
			->where('conversation_id', '=', $id)
			->where('read', '=', 0)
			->count();

		if ($unread > 0)
			\DB::table('conversation_messages')
				->where('to_user_id', '=', \Sentinel::getUser()->id)
				->where('conversation_id', '=', $id)
				->where('read', '=', 0)
				->update([
					'read' => 1,
					'read_at' => \Carbon\Carbon::now(),
				]);

		return view('conversation.show', [
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
		$conversation = Conversation::where('from_user_id', '=', \Sentinel::getUser()->id)
			->where('to_user_id', '=', $request->input('to_user_id'))
			->first();

		if (!isset($conversation)) {
			$conversation = Conversation::create([
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
