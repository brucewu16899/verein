<?php namespace Verein\Http\Controllers\User;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\Member;
use Verein\MemberComment;

class MemberCommentController extends Controller
{
	/**
	 * Rules to store the comment in the database.
	 *
	 * @var array
	 */
	protected $createMemberCommentRules = [
		'comment' => 'required',
	];

	/**
	 * Create a new controller and set the active tab.
	 */
	public function __construct()
	{
		\Config::set('app.active', 'member');
	}

	/**
	 * Validate the input and store the comment in the database.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $memberId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $memberId)
	{
		$member = Member::findOrFail($memberId);
		$this->validate($request, $this->createMemberCommentRules);

		$comment = MemberComment::create([
			'member_id' => $member->id,
			'comment' => $request->input('comment'),
		]);

		if (!isset($comment))
			abort(503);

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}

	/**
	 * Show the form to edit a comment.
	 *
	 * @param int $memberId
	 * @param int $commentId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($memberId, $commentId)
	{
		$member = Member::findOrFail($memberId);
		$comment = MemberComment::findOrFail($commentId);

		return view('member.comment.edit', [
			'member' => $member,
			'comment' => $comment,
		]);
	}

	/**
	 * Validate the input and update the comment in the database.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $memberId
	 * @param int $commentId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $memberId, $commentId)
	{
		$member = Member::findOrFail($memberId);
		$comment = MemberComment::findOrFail($commentId);
		$this->validate($request, $this->createMemberCommentRules);

		$comment->fill([
			'comment' => $request->input('comment'),
		]);

		if (!$comment->save())
			abort(503);

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}

	/**
	 * Delete comment.
	 *
	 * @param int $memberId
	 * @param int $commentId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($memberId, $commentId)
	{
		$member = Member::findOrFail($memberId);
		$comment = MemberComment::findOrFail($commentId);

		$comment->delete();

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}
}
