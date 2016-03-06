<?php namespace Verein\Http\Controllers\User;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\Member;

class MemberController extends Controller
{
	/**
	 * Rules to create a company
	 *
	 * @var array
	 */
	protected $createMemberRules = [
		'first_name' => 'max:255',
		'last_name' => 'max:255',
		'form_of_address' => 'max:255',
		'email' => 'email|max:255',
		'website' => 'url|max:255',
		'sex' => 'in:female,male',
		'birthday' => 'date|max:255',
	];

	/**
	 * Create a new controller and set the active tab.
	 */
	public function __construct()
	{
		\Config::set('app.active', 'member');
	}

	/**
	 * Display all users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('member.index', [
			'members' => Member::orderBy('created_at', 'desc')
				->orderBy('id', 'desc')
				->paginate(self::DEFAULT_PAGE_SIZE),
		]);
	}

	/**
	 * Display a single Member.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$member = Member::where('id', '=', $id)
			->with([
				'user',
				'comments',
			])
			->firstOrFail();

		return view('member.show', [
			'member' => $member,
		]);
	}

	/**
	 * Show the form to create a new Member.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('member.create');
	}

	/**
	 * Validate the input and store the Member in the database.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, $this->createMemberRules);

		$member = Member::create([
			'first_name' => $request->input('first_name'),
			'last_name' => $request->input('last_name'),
			'form_of_address' => $request->input('form_of_address'),
			'email' => $request->input('email'),
			'website' => $request->input('website'),
			'sex' => $request->input('sex'),
			'birthday' => $request->input('birthday'),
		]);

		if (!isset($member))
			abort(503);

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}

	/**
	 * Show the form to edit a Member.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$member = Member::findOrFail($id);

		return view('member.edit', [
			'member' => $member,
		]);
	}

	/**
	 * Validate the input and update the Member in the database.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$member = Member::findOrFail($id);
		$this->validate($request, $this->createMemberRules);

		$member->fill([
			'first_name' => $request->input('first_name'),
			'last_name' => $request->input('last_name'),
			'form_of_address' => $request->input('form_of_address'),
			'email' => $request->input('email'),
			'website' => $request->input('website'),
			'sex' => $request->input('sex'),
			'birthday' => $request->input('birthday'),
		]);

		if (!$member->save())
			abort(503);

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}

	/**
	 * Move a Member to the trash.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$member = Member::findOrFail($id);

		$member->delete();

		return redirect()->route('member.index');
	}
}
