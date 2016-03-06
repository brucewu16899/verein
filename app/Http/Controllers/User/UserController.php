<?php namespace Verein\Http\Controllers\User;

use Verein\Http\Controllers\Controller;
use Verein\User;

class UserController extends Controller
{
	/**
	 * Create a new controller and set the active tab.
	 */
	public function __construct()
	{
		\Config::set('app.active', 'user');
	}

	/**
	 * Display all users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('user.index', [
			'users' => User::orderBy('users.created_at', 'desc')
				->activated()
				->paginate(self::DEFAULT_PAGE_SIZE),
			'usersNotActivated' => User::orderBy('users.created_at', 'asc')
				->notActivated()
				->paginate(self::DEFAULT_PAGE_SIZE)
		]);
	}

	/**
	 * Display a single User.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return view('user.show', [
			'theUser' => User::with([
					'member',
				])
				->findOrFail($id),
		]);
	}

	/**
	 * Activates a User.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function activate($id)
	{
		$user = User::findOrFail($id);
		$user->activate();

		return redirect()->back();
	}

	/**
	 * Bans a User.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ban($id)
	{
		$user = User::findOrFail($id);
		$user->ban();

		return redirect()->back();
	}

	/**
	 * Unbans a User.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function unban($id)
	{
		$user = User::findOrFail($id);
		$user->unban();

		return redirect()->back();
	}
}
