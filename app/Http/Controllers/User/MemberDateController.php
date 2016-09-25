<?php namespace Verein\Http\Controllers\User;

use Illuminate\Http\Request;

use Verein\Http\Controllers\Controller;
use Verein\Member;
use Verein\MemberDate;

class MemberDateController extends Controller
{
	/**
	 * Rules to store the data in the database.
	 *
	 * @var array
	 */
	protected $createMemberDateRules = [
		'type' => 'required|in:private_phone,private_mobile,private_fax,private_email,private_website,private_address,work_phone,work_mobile,work_fax,work_email,work_website,work_address',
		'value' => 'required',
	];

	/**
	 * Get possible values for the type column.
	 *
	 * @return array
	 */
	protected function getTypes()
	{
		return [
			'private_phone' => trans('member.date.private_phone'),
			'private_mobile' => trans('member.date.private_mobile'),
			'private_fax' => trans('member.date.private_fax'),
			'private_email' => trans('member.date.private_email'),
			'private_website' => trans('member.date.private_website'),
			'private_address' => trans('member.date.private_address'),
			'work_phone' => trans('member.date.work_phone'),
			'work_mobile' => trans('member.date.work_mobile'),
			'work_fax' => trans('member.date.work_fax'),
			'work_email' => trans('member.date.work_email'),
			'work_website' => trans('member.date.work_website'),
			'work_address' => trans('member.date.work_address'),
		];
	}

	/**
	 * Create a new controller and set the active tab.
	 */
	public function __construct()
	{
		\Config::set('app.active', 'member');
	}

	/**
	 * Show the form to create new member data.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($memberId)
	{
		$member = Member::findOrFail($memberId);

		return view('member.data.create', [
			'member' => $member,
			'types' => $this->getTypes(),
		]);
	}

	/**
	 * Validate the input and store the member data in the database.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $memberId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $memberId)
	{
		$member = Member::findOrFail($memberId);
		$this->validate($request, $this->createMemberDateRules);

		$data = MemberDate::create([
			'member_id' => $member->id,
			'type' => $request->input('type'),
			'value' => $request->input('value'),
		]);

		if (!isset($data))
			abort(503);

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}

	/**
	 * Show the form to edit member data.
	 *
	 * @param int $memberId
	 * @param int $dataId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($memberId, $dataId)
	{
		$member = Member::findOrFail($memberId);
		$date = MemberDate::findOrFail($dataId);

		return view('member.data.edit', [
			'member' => $member,
			'date' => $date,
			'types' => $this->getTypes(),
		]);
	}

	/**
	 * Validate the input and update the member data in the database.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $memberId
	 * @param int $dataId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $memberId, $dataId)
	{
		$member = Member::findOrFail($memberId);
		$data = MemberDate::findOrFail($dataId);
		$this->validate($request, $this->createMemberDateRules);

		$data->fill([
			'type' => $request->input('type'),
			'value' => $request->input('value'),
		]);

		if (!$data->save())
			abort(503);

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}

	/**
	 * Delete data.
	 *
	 * @param int $memberId
	 * @param int $dataId
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($memberId, $dataId)
	{
		$member = Member::findOrFail($memberId);
		$data = MemberDate::findOrFail($dataId);

		$data->delete();

		return redirect()->route('member.show', [
			'member' => $member->id,
		]);
	}
}
